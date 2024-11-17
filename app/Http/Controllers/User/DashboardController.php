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
    //Trang dashboard người dùng
    public function dashboard()
    {
        return view('user.dashboard');
    }
    public function editProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'required|regex:/^0\d{9,10}$/',  // Số điện thoại bắt đầu bằng 0 và có 10 hoặc 11 chữ số
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
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Updated personal information successfully!',
            'data' => $user
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
        /** @var \App\Models\User $user */
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
        $hasDefaultAddress = User_shipping_address::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->exists();
        // Tạo địa chỉ mới
        $address_shipping = new User_shipping_address;
        $address_shipping->full_name = $request->full_name;
        $address_shipping->phone_number = $request->phone_number;
        $address_shipping->address = $request->address;
        $address_shipping->user_id = auth()->id();
        $address_shipping->is_active = $hasDefaultAddress ? 0 : 1;
        $address_shipping->save();

        return response()->json([
            'success' => true,
            'message' => 'Shipping address added successfully.',
            'data' => $address_shipping
        ]);
    }

    public function editAddress(Request $request, $id)
    {
        $userId = auth()->user()->id;
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

        $user = User::findOrFail($userId);
        $address = $user->user_shipping_addresses()->findOrFail($id);
        $address->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.',
            'data' => $address
        ]);
    }

    public function deleteAddress($id)
    {
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        // Tìm địa chỉ theo ID
        $address = $user->user_shipping_addresses()->findOrFail($id);
        // Kiểm tra nếu địa chỉ là mặc định
        if ($address->is_active == 1) {
            return back()->with('statusError', 'Bạn không thể xoá địa chỉ mặc định.');
        }
        $address->delete();
        return back()->with('statusSuccess', 'Địa chỉ đã được xóa thành công.');
    }

    public function setDefaultShippingAddress($id)
    {
        // Lấy tất cả các địa chỉ của người dùng
        $addresses = Auth::user()->user_shipping_addresses;

        // Đặt tất cả các địa chỉ thành không phải mặc định
        foreach ($addresses as $address) {
            $address->is_active = 0;
            $address->save();
        }

        // Đặt địa chỉ được chọn thành mặc định
        $defaultAddress = User_shipping_address::findOrFail($id);
        $defaultAddress->is_active = 1;
        $defaultAddress->save();

        return redirect()->back()->with('statusSuccess', 'Địa chỉ mặc định đã được cập nhật thành công.');
    }
}
