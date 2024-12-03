<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_vote;
use App\Models\Status;
use App\Models\Status_order;
use Illuminate\Support\Facades\Auth;
use App\Models\User_shipping_address;
use Illuminate\Support\Facades\DB;
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

        return redirect()->back()->with('success', 'Địa chỉ mặc định đã được cập nhật thành công.');
    }
    //===============================ORDER===============================
    public function orderTracking()
    {
        return view('user.order-tracking');
    }
    public function getOrders()
    {
        // Lấy trạng thái đơn hàng
        $status_order = request()->input('status_order');
        $user_id = Auth::user()->id;

        if ($status_order == 0) {
            $get_orders = Order::with(['order_details.product_variant.product'])
                ->leftJoinSub(
                    DB::table('status_orders as so1')
                        ->joinSub(
                            DB::table('status_orders')
                                ->select('order_id', DB::raw('MAX(status_id) as max_status_id'))
                                ->groupBy('order_id'),
                            'so2',
                            function ($join) {
                                $join->on('so1.order_id', '=', 'so2.order_id')
                                    ->on('so1.status_id', '=', 'so2.max_status_id');
                            }
                        )
                        ->select('so1.order_id', 'so1.status_id', 'so1.created_at'), // Chỉ lấy các cột cần thiết
                    'so',
                    'orders.id',
                    '=',
                    'so.order_id'
                )
                ->leftJoin('statuses as s', 'so.status_id', '=', 's.id')
                ->select('orders.*', 'so.status_id as latest_status_id', 's.name as status_name') // Giữ nguyên cột orders.*
                ->where('orders.user_id', $user_id)
                ->orderBy('orders.created_at', 'desc')
                ->get();
        } else {
            // Lọc đơn hàng dựa trên trạng thái cụ thể
            $get_orders = Order::whereHas('status_orders', function ($query) use ($status_order) {
                $query->where('status_id', $status_order)
                    ->whereRaw('id = (SELECT MAX(id) FROM status_orders so WHERE so.order_id = status_orders.order_id)');
            })
                ->with(['status_orders' => function ($query) {
                    $query->latest(); // Lấy trạng thái mới nhất cho mỗi đơn hàng
                }, 'order_details.product_variant.product'])
                ->where('orders.user_id', $user_id)
                ->orderBy('orders.created_at', 'desc')
                ->get();
        }

        // Trả về danh sách đơn hàng
        $response = [
            'success' => true,
            'message' => 'Lấy danh sách đơn hàng thành công!',
            'data' => $get_orders
        ];
        return response()->json($response);
    }
    public function cancelOrder()
    {
        $order_id = request()->input('order_id');
        if ($order_id) {
            $get_order_by_id = Order::find($order_id)->first();
            if ($get_order_by_id) {
                $get_cancelled_status = Status::where('name', 'Cancelled')->first();
                $get_shipping_status = Status::where('name', 'Shipping')->first();
                if ($get_cancelled_status && $get_shipping_status) {
                    $valid = true;
                    $get_cancelled_status_order = Status_order::where('order_id', $order_id)->where('status_id', $get_cancelled_status->id)->first();
                    $get_shipping_status_order = Status_order::where('order_id', $order_id)->where('status_id', $get_shipping_status->id)->first();
                    if ($get_cancelled_status_order) {
                        $valid = false;
                        $response = [
                            'success' => false,
                            'message' => 'Đơn hàng này đã trong trạng thái hủy!',
                        ];
                    }
                    if ($get_shipping_status_order) {
                        $valid = false;
                        $response = [
                            'success' => false,
                            'message' => 'Đơn hàng này đã trong trạng vận chuyển, không thể hủy!',
                        ];
                    }
                    if ($valid) {
                        Status_order::create([
                            'order_id' => $order_id,
                            'status_id' => $get_cancelled_status->id
                        ]);
                        $response = [
                            'success' => true,
                            'message' => 'Hủy đơn hàng thành công!',
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Không tìm thấy trạng thái!',
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }
    public function confirmDoneOrder()
    {
        $order_id = request()->input('order_id');
        if ($order_id) {
            $get_order_by_id = Order::find($order_id)->first();
            if ($get_order_by_id) {
                $get_completed_status = Status::where('name', 'Completed')->first();
                if ($get_completed_status) {
                    $get_completed_status_order = Status_order::where('order_id', $order_id)->where('status_id', $get_completed_status->id)->first();
                    if (!$get_completed_status_order) {
                        Status_order::create([
                            'order_id' => $order_id,
                            'status_id' => $get_completed_status->id
                        ]);
                        $response = [
                            'success' => true,
                            'message' => 'Xác nhận hoàn thành đơn hàng thành công!',
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'Đơn hàng này đã trong trạng thái hoàn thành!',
                        ];
                    }
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }

    public function getOrderDetail()
    {
        $order_id = request()->input('order_id');
        if ($order_id) {
            $query_data = Order::with(['order_details.product_variant.product', 'status_orders.status'])->where('id', $order_id)->get();
            if ($query_data) {
                $response = [
                    'success' => true,
                    'message' => 'Lấy dữ liệu đơn hàng thành công!',
                    'data' => $query_data
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }
    public function getVoteOrderDetail()
    {
        $order_detail_id = request()->input('order_detail_id');
        if ($order_detail_id) {
            $get_vote_by_order_detail_id = Product_vote::where('order_detail_id', $order_detail_id)->where('user_id', Auth::user()->id)->first();
            if ($get_vote_by_order_detail_id) {
                $response = [
                    'success' => true,
                    'message' => 'Lấy dữ liệu đơn hàng thành công!',
                    'data' => $get_vote_by_order_detail_id
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Đơn hàng này chưa được đánh giá!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }
    public function submitVoteOrderDetail()
    {
        $user_id = Auth::user()->id;
        $order_detail_id = request()->input(key: 'order_detail_id');
        $star = request()->input('star');
        $content = request()->input('content');
        if (!$star || $star == 0) {
            $response = [
                'success' => false,
                'message' => 'Đánh giá không hợp lệ!',
            ];
            return response()->json($response);
        }
        if ($order_detail_id) {
            $get_vote_by_order_detail_id = Product_vote::where('order_detail_id', $order_detail_id)->where('user_id', Auth::user()->id)->first();
            if (!$get_vote_by_order_detail_id) {
                $product_variant_id = Order_detail::find($order_detail_id)?->product_variant_id;
                $order_id = Order_detail::find($order_detail_id)?->order_id;
                if ($product_variant_id) {
                    $create_new_vote_order_detail = Product_vote::create([
                        'content' => $content,
                        'star' => $star,
                        'order_detail_id' => $order_detail_id,
                        'product_variant_id' => $product_variant_id,
                        'user_id' => $user_id
                    ]);
                    if ($create_new_vote_order_detail) {
                        $query_data = Order::with(['order_details.product_variant.product', 'status_orders.status'])->where('id', $order_id)->get()[0];
                        $response = [
                            'success' => true,
                            'message' => 'Đánh giá sản phẩm thành công!',
                            'data' => $query_data
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'Đánh giá sản phẩm không thành công!',
                        ];
                    }
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Đơn hàng này đã được đánh giá!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }
    public function submitEditVoteOrderDetail()
    {
        $user_id = Auth::user()->id;
        $order_detail_id = request()->input(key: 'order_detail_id');
        $vote_id = request()->input(key: 'vote_id');
        $star = request()->input('star');
        $content = request()->input('content');
        if (!$star || $star == 0) {
            $response = [
                'success' => false,
                'message' => 'Đánh giá không hợp lệ!',
            ];
            return response()->json($response);
        }
        if ($order_detail_id && $vote_id) {
            $get_vote_by_order_detail_id = Product_vote::where('id', $vote_id)->where('user_id', $user_id)->first();
            if ($get_vote_by_order_detail_id) {
                if ($get_vote_by_order_detail_id->edit == 0) {
                    $get_vote_by_order_detail_id->update([
                        'star' => $star,
                        'content' => $content,
                        'edit' => 1
                    ]);
                    $product_variant_id = Order_detail::find($order_detail_id)?->product_variant_id;
                    $order_id = Order_detail::find($order_detail_id)?->order_id;
                    if ($product_variant_id && $get_vote_by_order_detail_id->edit == 1) {
                        $query_data = Order::with(['order_details.product_variant.product', 'status_orders.status'])->where('id', $order_id)->get()[0];
                        $response = [
                            'success' => true,
                            'message' => 'Sửa đánh giá sản phẩm thành công!',
                            'data' => $query_data
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'Sửa đánh giá sản phẩm không thành công!',
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Đơn hàng này đã được đánh giá!',
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Đơn hàng này chưa có đánh giá, không thể sửa!',
                ];
            }
            return response()->json($response);
        } else {
            return redirect()->route('dashboard')->with('statusError', 'Có lỗi xảy ra!');
        }
    }
}
