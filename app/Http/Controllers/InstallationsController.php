<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Customer;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Installation::with('customer')
            ->latest()
            ->paginate(12);

        return view('installations.index', compact('installations'));
    }

    public function create()
    {
        return view('installations.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'installation_type' => 'required',
    ]);


    $customer = Customer::firstOrCreate(
        [
            'mobile' => $request->phone
        ],
        [
            'name' => $request->name,
            'national_code' => $request->national_code,
        ]
    );


    $installation = Installation::create([

        'customer_id' => $customer->id,

        'installation_type' => $request->installation_type,

        'tracking_code' =>
            'PLZI' . now()->format('YmdHis') . rand(100,999),

        'status' => 'created',

        'payment_status' => 'pending',

        'sign_type' => $request->sign_type,

        'payment_type' => $request->payment_type,

        'location_type' => $request->location_type,

    ]);


    return redirect()
        ->route('installations.prepare', $installation->id);

}

    public function show(Installation $installation)
    {
        return view('installations.show', compact('installation'));
    }

    public function edit(Installation $installation)
    {
        //
    }

    public function update(Request $request, Installation $installation)
    {
        //
    }

    public function destroy(Installation $installation)
    {
        //
    }
}