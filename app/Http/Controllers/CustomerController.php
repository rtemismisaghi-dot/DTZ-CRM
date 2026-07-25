<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * نمایش لیست مشتری‌ها
     */
    public function index(Request $request)
    {
         $query = Customer::query();

    // 🔍 سرچ
    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
    }

    // 📄 صفحه‌بندی
    $customers = $query->latest()->paginate(5);

    return view('customers.index', compact('customers'));
    }

    /**
     * نمایش فرم ساخت مشتری جدید
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * ذخیره مشتری جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
        ]);

        Customer::create([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully');
    }

    /**
     * نمایش فرم ویرایش
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * آپدیت مشتری
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
        ]);

        $customer->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }

    /**
     * حذف مشتری
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully');
    }
}