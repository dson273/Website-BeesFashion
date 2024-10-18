<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_shipping_address;
use App\Models\User;


class DashboardController extends Controller
{
    public function addAddress(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email'
        ]);

        // Tạo địa chỉ mới
        //auth()->user()->user_shipping_address()->create($request->all());
        User_shipping_address::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'user_id' => auth()->id(), // Lấy ID người dùng đang đăng nhập
            'is_active' => 0, // Mặc định là 0
        ]);

        return redirect()->back()->with('success', 'Địa chỉ giao hàng đã được thêm thành công.');
    }

    public function editAddress(Request $request, $id) {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email'
        ]);

        $address = auth()->user()->user_shipping_addresses()->where('id', $id)->first();
        $address->update($request->all());
        return back()->with('success', 'Address updated successfully.');
    }

    public function deleteAddress($id) {
        // Tìm địa chỉ bằng cách sử dụng where và id của địa chỉ
        $address = auth()->user()->user_shipping_addresses()->where('id', $id)->first();
        $address->delete();
        return back()->with('success', 'Địa chỉ đã được xóa thành công.');
    }

    public function setDefaultShippingAddress($id)
    {
        // Lấy tất cả các địa chỉ của người dùng
        $addresses = auth()->user()->user_shipping_addresses;

        // Đặt tất cả các địa chỉ thành không phải mặc định
        foreach ($addresses as $address) {
            $address->is_active = 0;
            $address->save();
        }

        // Đặt địa chỉ được chọn thành mặc định
        $defaultAddress = User_shipping_address::findOrFail($id);
        $defaultAddress->is_active = 1;
        $defaultAddress->save();

        return redirect()->back()->with('success', 'Địa chỉ mặc định đã được cập nhật thành công.');
    }
}
