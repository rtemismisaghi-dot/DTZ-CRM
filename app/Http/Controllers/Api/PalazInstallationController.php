<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Installation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PalazInstallationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $expectedToken = (string) config('palaz.integration_token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || $providedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:120'],
            'product_code' => ['nullable', 'string', 'max:100'],
            'product_title' => ['nullable', 'string', 'max:255'],
            'product_model' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:4000'],
            'palaz_order_id' => ['nullable', 'string', 'max:120'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'rolls' => ['nullable', 'array', 'max:100'],
            'rolls.*.code' => ['nullable', 'string', 'max:100'],
            'rolls.*.name' => ['nullable', 'string', 'max:255'],
            'rolls.*.model' => ['nullable', 'string', 'max:255'],
            'rolls.*.width' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'rolls.*.length' => ['nullable', 'numeric', 'min:1', 'max:15'],
            'rolls.*.quantity' => ['nullable', 'numeric', 'min:1'],
            'rolls.*.area' => ['nullable', 'numeric', 'min:0'],
        ]);

        $reference = $data['palaz_order_id'] ?? null;
        $existing = $reference
            ? Installation::where('external_source', 'palaz')->where('external_reference', $reference)->first()
            : null;

        if ($existing) {
            return $this->installationResponse($existing, true);
        }

        $customer = Customer::firstOrCreate(
            ['mobile' => $data['phone']],
            [
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
                'lat' => $data['latitude'] ?? null,
                'lng' => $data['longitude'] ?? null,
            ]
        );

        if (! $customer->wasRecentlyCreated) {
            $customer->fill([
                'name' => $data['name'],
                'address' => $data['address'] ?? $customer->address,
                'lat' => $data['latitude'] ?? $customer->lat,
                'lng' => $data['longitude'] ?? $customer->lng,
            ])->save();
        }

        $productSummary = collect([
            $data['product_title'] ?? null,
            $data['product_model'] ?? null,
            isset($data['product_code']) ? 'کد: ' . $data['product_code'] : null,
            isset($data['quantity']) ? 'تعداد: ' . $data['quantity'] : null,
            isset($data['area']) ? 'متراژ اولیه: ' . $data['area'] : null,
        ])->filter()->implode(' | ');

        $description = collect([
            $productSummary ? 'محصول: ' . $productSummary : null,
            isset($data['city']) ? 'شهر: ' . $data['city'] : null,
            $data['description'] ?? null,
        ])->filter()->implode("\n");

        $installation = Installation::create([
            'customer_id' => $customer->id,
            'tracking_code' => $this->trackingCode(),
            'installation_type' => 'installation',
            'title' => $data['product_title'] ?? 'درخواست نصب از پالاز آنلاین',
            'description' => $description ?: null,
            'status' => 'created',
            'payment_status' => 'pending',
            'terms_type' => 'online',
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'external_source' => 'palaz',
            'external_reference' => $reference,
            'quote_payload' => [
                'source' => 'palaz_online',
                'purchased_area' => isset($data['area']) ? (float) $data['area'] : null,
                'purchased_quantity' => isset($data['quantity']) ? (float) $data['quantity'] : null,
                'rolls' => $data['rolls'] ?? [],
            ],
        ]);

        return $this->installationResponse($installation, false);
    }

    public function quote(Request $request, Installation $installation): JsonResponse
    {
        $expectedToken = (string) config('palaz.integration_token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || $providedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        return response()->json([
            'success' => true,
            'installation_id' => $installation->id,
            'tracking_code' => $installation->tracking_code,
            'external_reference' => $installation->external_reference,
            'total_amount' => (float) ($installation->quote_amount ?? 0),
            'quote_payload' => $installation->quote_payload,
        ]);
    }

    public function completeApi(Request $request, Installation $installation): JsonResponse
    {
        $expectedToken = (string) config('palaz.integration_token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || $providedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $data = $request->validate([
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payload' => ['nullable', 'array'],
        ]);

        $existingPayload = is_array($installation->quote_payload) ? $installation->quote_payload : [];
        $finalPayload = is_array($data['payload'] ?? null) ? $data['payload'] : [];
        $purchasedArea = (float) ($existingPayload['purchased_area'] ?? 0);
        $baseInstallationAmount = $purchasedArea > 0 ? $purchasedArea * 385000 : 0;
        $finalTotalAmount = max((float) $data['total_amount'], $baseInstallationAmount);

        $installation->update([
            'quote_amount' => $finalTotalAmount,
            'quote_payload' => array_merge($existingPayload, [
                'final_quote' => $finalPayload,
                'final_total_amount' => $finalTotalAmount,
                'purchased_area_locked' => $purchasedArea > 0,
            ]),
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'installation_id' => $installation->id,
            'tracking_code' => $installation->tracking_code,
            'total_amount' => (float) $installation->quote_amount,
        ]);
    }

    public function complete(Request $request, Installation $installation): JsonResponse
    {
        $data = $request->validate([
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payload' => ['nullable', 'array'],
        ]);

        $existingPayload = is_array($installation->quote_payload)
            ? $installation->quote_payload
            : [];

        $finalPayload = is_array($data['payload'] ?? null)
            ? $data['payload']
            : [];

        // For Palaz Online orders the purchased rolls are authoritative.
        // The customer must not be able to change the purchased metrage
        // or lower the installation quote by editing the browser payload.
        $purchasedArea = (float) ($existingPayload['purchased_area'] ?? 0);
        $baseInstallationAmount = $purchasedArea > 0
            ? $purchasedArea * 385000
            : 0;

        $submittedTotal = (float) $data['total_amount'];
        $finalTotalAmount = max($submittedTotal, $baseInstallationAmount);

        $installation->update([
            'quote_amount' => $finalTotalAmount,
            'quote_payload' => array_merge($existingPayload, [
                'final_quote' => $finalPayload,
                'final_total_amount' => $finalTotalAmount,
                'purchased_area_locked' => $purchasedArea > 0,
            ]),
            'payment_status' => 'pending',
        ]);

        $palazBase = rtrim((string) config('services.palaz.url'), '/');
        $orderId = $installation->external_reference;
        $callback = $palazBase !== '' && $orderId
            ? $palazBase . '/checkout/installation-complete?order_id=' . rawurlencode($orderId)
                . '&installation_id=' . $installation->id
                . '&tracking_code=' . rawurlencode($installation->tracking_code)
            : null;

        return response()->json([
            'success' => true,
            'installation_id' => $installation->id,
            'tracking_code' => $installation->tracking_code,
            'total_amount' => (float) $installation->quote_amount,
            'callback_url' => $callback,
        ]);
    }

    private function installationResponse(Installation $installation, bool $existing): JsonResponse
    {
        $prepareUrl = URL::temporarySignedRoute(
            'palaz.installations.prepare',
            now()->addHours(4),
            ['installation' => $installation->id]
        );

        return response()->json([
            'success' => true,
            'existing' => $existing,
            'installation_id' => $installation->id,
            'tracking_code' => $installation->tracking_code,
            'status' => $installation->status,
            'prepare_url' => $prepareUrl,
        ], $existing ? 200 : 201);
    }

    private function trackingCode(): string
    {
        do {
            $code = 'PLZI' . now()->format('YmdHis') . Str::upper(Str::random(4));
        } while (Installation::where('tracking_code', $code)->exists());

        return $code;
    }
}
