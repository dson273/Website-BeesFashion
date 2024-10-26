<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User_shipping_address;


class DashboardController extends Controller
{
    public function editProfile(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'required|regex:/^0\d{9,10}$/',  // Số điện thoại bắt đầu bằng 0 và có 10 hoặc 11 chữ số
            'address' => 'nullable|string',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter phone number.',
            'email.required' => 'Please enter email.',
            'email.unique' => 'This email is already in use.',
            'phone.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
        ]);

        $user->update([
            'full_name' => $validatedData['full_name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Updated personal information successfully!',
            'user' => $user // Trả về đối tượng người dùng đã được cập nhật
        ]);
    }

    public function addAddress(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
        ]);

        // Tạo địa chỉ mới
        //auth()->user()->user_shipping_address()->create($request->all());
        User_shipping_address::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'user_id' => auth()->id(), // Lấy ID người dùng đang đăng nhập
            'is_active' => 0, // Mặc định là 0
        ]);

        return redirect()->back()->with('success', 'Địa chỉ giao hàng đã được thêm thành công.');
    }

    public function editAddress(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
        ]);

        $address = Auth::user()->user_shipping_addresses()->where('id', $id)->first();
        $address->update($request->all());
        return back()->with('success', 'Address updated successfully.');
    }

    public function deleteAddress($id)
    {
        // Tìm địa chỉ bằng cách sử dụng where và id của địa chỉ
        $address = Auth::user()->user_shipping_addresses()->where('id', $id)->first();
        $address->delete();
        return back()->with('success', 'Địa chỉ đã được xóa thành công.');
    }

    // public function setDefaultShippingAddress($id)
    // {
    //     // Lấy tất cả các địa chỉ của người dùng
    //     $addresses = Auth::user()->user_shipping_addresses;

    //     // Đặt tất cả các địa chỉ thành không phải mặc định
    //     foreach ($addresses as $address) {
    //         $address->is_active = 0;
    //         $address->save();
    //     }

    //     // Đặt địa chỉ được chọn thành mặc định
    //     $defaultAddress = User_shipping_address::findOrFail($id);
    //     $defaultAddress->is_active = 1;
    //     $defaultAddress->save();

    //     return redirect()->back()->with('success', 'Địa chỉ mặc định đã được cập nhật thành công.');
    // }
}
