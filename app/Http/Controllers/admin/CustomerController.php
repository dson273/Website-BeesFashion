<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\User_ban;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $customers = User::with('defaultShippingAddress')->where('role', 'member')->paginate(10);
    return view('admin.customers.index', compact('customers'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = User::with(['user_bans', 'user_shipping_addresses'])->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $customer = User::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Cập nhật khách hàng thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
