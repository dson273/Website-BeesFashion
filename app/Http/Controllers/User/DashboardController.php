<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User_shipping_address;
use Illuminate\Support\Facades\Hash;

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
            'data' => $user // Trả về đối tượng người dùng đã được cập nhật
        ]);
    }

    public function editPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ], [
            'current_password.require' => 'Please enter current password.',
            'new_password.required' => 'Please enter a new password.',
            'new_password.min' => 'The new password must have at least 6 characters.',
            'new_password.confirmed' => 'Confirm passwords do not match.',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại có khớp không
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => 'Current password is incorrect.'], 400);
        }
        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function addAddress(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^0\d{9,10}$/',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone_number.required' => 'Please enter your phone number.',
            'phone_number.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
            'address.required' => 'Please enter your address.'
        ]);

        // Tạo địa chỉ mới
        $address_shipping = new User_shipping_address;
        $address_shipping->full_name = $request->full_name;
        $address_shipping->phone_number = $request->phone_number;
        $address_shipping->address = $request->address;
        $address_shipping->user_id = auth()->id();
        $address_shipping->is_active = 0;
        $address_shipping->save();

        return response()->json([
            'success' => true,
            'message' => 'Shipping address added successfully.',
            'data' => $address_shipping
        ]);
    }

    public function editAddress(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^0\d{9,10}$/',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone_number.required' => 'Please enter your phone number.',
            'phone_number.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
            'address.required' => 'Please enter your address.'
        ]);

        $address = Auth::user()->user_shipping_addresses()->findOrFail($id);
        $address->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.'
        ]);
    }

    public function deleteAddress($id)
    {
        // Tìm địa chỉ bằng cách sử dụng where và id của địa chỉ
        $address = Auth::user()->user_shipping_addresses()->where('id', $id)->first();
        $address->delete();
        return back()->with('statusSuccess', 'Địa chỉ đã được xóa thành công.');
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

    public function orderTracking()
    {
        return view('user.order-tracking');
    }
}
