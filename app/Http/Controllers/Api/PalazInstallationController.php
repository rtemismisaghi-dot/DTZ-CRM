<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Installation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PalazInstallationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $expectedToken = (string) config('palaz.integration_token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || $providedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
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
            'description' => ['nullable', 'string', 'max:2000'],
            'palaz_order_id' => ['nullable', 'string', 'max:120'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $reference = $data['palaz_order_id'] ?? null;

        if ($reference) {
            $existing = Installation::where('external_source', 'palaz')
                ->where('external_reference', $reference)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'existing' => true,
                    'installation_id' => $existing->id,
                    'tracking_code' => $existing->tracking_code,
                    'status' => $existing->status,
                ]);
            }
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

        if ($customer->wasRecentlyCreated === false) {
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
            $data['product_code'] ? 'کد: ' . $data['product_code'] : null,
            isset($data['quantity']) ? 'تعداد: ' . $data['quantity'] : null,
            isset($data['area']) ? 'متراژ: ' . $data['area'] : null,
        ])->filter()->implode(' | ');

        $description = collect([
            $productSummary ? 'محصول: ' . $productSummary : null,
            $data['city'] ?? null ? 'شهر: ' . $data['city'] : null,
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
        ]);

        return response()->json([
            'success' => true,
            'existing' => false,
            'installation_id' => $installation->id,
            'tracking_code' => $installation->tracking_code,
            'status' => $installation->status,
        ], 201);
    }

    private function trackingCode(): string
    {
        do {
            $code = 'PLZI' . now()->format('YmdHis') . Str::upper(Str::random(4));
        } while (Installation::where('tracking_code', $code)->exists());

        return $code;
    }
}
