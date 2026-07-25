<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeasurementController extends Controller
{
    public function index()
    {
        $measurements = Measurement::with('customer')
            ->latest()
            ->paginate(12);

        return view('measurements.index', compact('measurements'));
    }

public function create(Request $request)
{
    

    $types = [
        'carpet'    => 'نصب موکت',
        'grass'     => 'چمن مصنوعی',
        'tile'      => 'موکت تایل',
        'laminate'  => 'لمینیت',
        'wallpaper' => 'کاغذ دیواری',
    ];

    $type = $request->get('type');

    if (!$type) {
        return view('measurements.create', compact('types'));
    }

    $customers = Customer::orderBy('name')->get();

    return view('measurements.create_form', compact('type', 'customers'));
}

    public function searchCustomer(Request $request)
    {
    

        $request->validate([
            'phone' => 'required'
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => 'found',
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'national_code' => $customer->national_code,
        ]);
    }


public function store(Request $request)
{
    $request->validate([
        'measurement_type' => 'required',
        'name'             => 'required|string|max:255',
        'phone'            => 'required|string|max:20',
        'national_code'    => 'nullable|string|max:20',
        'measurement_by'   => 'nullable|string',
        'payment_type'     => 'nullable|string',
        'terms_type'       => 'nullable|string',
        'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // پیدا کردن یا ساخت مشتری
    $customer = Customer::firstOrCreate(
        ['mobile' => $request->phone],
        [
            'name' => $request->name,
            'national_code' => $request->national_code,
        ]
    );

    $data = [];

    $data['customer_id']      = $customer->id;
    $data['tracking_code']    = 'PLZS' . now()->format('YmdHis') . rand(100, 999);
    $data['measurement_type'] = $request->measurement_type;

    $data['title'] = match ($request->measurement_type) {
        'carpet'    => 'اندازه‌گیری موکت',
        'grass'     => 'اندازه‌گیری چمن مصنوعی',
        'tile'      => 'اندازه‌گیری موکت تایل',
        'laminate'  => 'اندازه‌گیری لمینیت',
        'wallpaper' => 'اندازه‌گیری کاغذ دیواری',
        default     => 'اندازه‌گیری',
    };

    $data['description']      = null;
    $data['measurement_date'] = null;

    $data['measurement_by'] = $request->measurement_by;
    $data['terms_type']     = $request->terms_type;

    // چون در فرم payment_type ارسال می‌شود
    $data['payment_status'] = $request->payment_type;

    $data['latitude']  = null;
    $data['longitude'] = null;
    $data['address']   = null;

    $data['status'] = 'created';

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
            ->store('measurements', 'public');
    }

    Measurement::create($data);

    return redirect()
        ->route('measurements.index')
        ->with('success', 'اندازه‌گیری با موفقیت ثبت شد.');
}

    public function edit(Measurement $measurement)
    {
        $types = [
            'carpet'    => 'نصب موکت',
            'grass'     => 'چمن مصنوعی',
            'tile'      => 'موکت تایل',
            'laminate'  => 'لمینیت',
            'wallpaper' => 'کاغذ دیواری',
        ];

        $customers = Customer::orderBy('name')->get();

        return view('measurements.edit', compact('measurement', 'types', 'customers'));
    }

    public function update(Request $request, Measurement $measurement)
    {
        $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'measurement_type' => 'required',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'measurement_date' => 'nullable|date',
            'status'           => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'customer_id',
            'measurement_type',
            'title',
            'description',
            'measurement_date',
            'status',
        ]);

        if ($request->hasFile('image')) {

            if ($measurement->image) {
                Storage::disk('public')->delete($measurement->image);
            }

            $data['image'] = $request->file('image')
                ->store('measurements', 'public');
        }

        $measurement->update($data);

        return redirect()
            ->route('measurements.index')
            ->with('success', 'ویرایش شد');
    }
public function show(Measurement $measurement)
{
    $measurement->load('customer');

    return view('measurements.show', compact('measurement'));
}
    public function destroy(Measurement $measurement)
    {
        if ($measurement->image) {
            Storage::disk('public')->delete($measurement->image);
        }

        $measurement->delete();

        return redirect()
            ->route('measurements.index')
            ->with('success', 'حذف شد');
    }
}