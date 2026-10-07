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

       'terms_type' => $request->sign_type,

    ]);


    return redirect()
         ->route('installations.prepare', $installation->id);

}

    public function show(Installation $installation)
    {
        return view('installations.show', compact('installation'));
    }
public function prepare(Installation $installation)
{
    // A Palaz Online installation must always use the isolated customer flow,
    // even when an old/stale link points to the normal CRM prepare route.
    if ($installation->external_source === 'palaz') {
        $completeUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'palaz.installations.complete',
            now()->addHours(4),
            ['installation' => $installation->id]
        );

        $palazRolls = data_get($installation->quote_payload, 'rolls', []);

        return view('installations.prepare', [
            'installation' => $installation,
            'completeUrl' => $completeUrl,
            'palazRolls' => $palazRolls,
            'palazCustomerView' => true,
        ]);
    }

    return view('installations.prepare', compact('installation'));
}

public function palazPrepare(Installation $installation)
{
    $completeUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'palaz.installations.complete',
        now()->addHours(4),
        ['installation' => $installation->id]
    );

    $palazRolls = data_get($installation->quote_payload, 'rolls', []);

    return view('installations.prepare', [
        'installation' => $installation,
        'completeUrl' => $completeUrl,
        'palazRolls' => $palazRolls,
        'palazCustomerView' => true,
    ]);
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