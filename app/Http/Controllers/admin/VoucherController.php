<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listVouchers = Voucher::all();
        return view('admin.vouchers.index', compact('listVouchers'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:vouchers,code', // Mã voucher phải viết liền (không khoảng trắng)
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date', // Ngày bắt đầu phải có và trước hoặc bằng ngày hết hạn
            'end_date' => 'required|date|after_or_equal:start_date',   // Ngày hết hạn phải có và sau hoặc bằng ngày bắt đầu
            'minimum_order_value' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Kiểm tra file ảnh nếu có
        ], [
            'name.required' => 'Tên voucher là bắt buộc.',
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.regex' => 'Mã voucher phải viết liền, không chứa khoảng trắng.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'amount.required' => 'Giá trị giảm là bắt buộc.',
            'amount.numeric' => 'Giá trị giảm phải là một số.',
            'amount.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 0.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'minimum_order_value.required' => 'Giá trị tối thiểu đơn hàng là bắt buộc.',
            'minimum_order_value.numeric' => 'Giá trị tối thiểu đơn hàng phải là một số.',
            'minimum_order_value.min' => 'Giá trị tối thiểu đơn hàng phải lớn hơn hoặc bằng 0.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày hết hạn.',
            'end_date.required' => 'Ngày hết hạn là bắt buộc.',
            'end_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
        ]);

        if ($request->amount >= $request->minimum_order_value) {
            return back()->withErrors(['discount_value' => 'Giá trị giảm phải nhỏ hơn giá tối thiểu đơn hàng.'])->withInput();
        }

        $params = $request->except('_token');

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads/vouchers/images', $imageName, 'public');
            $params['image'] = $imageName;
        } else {
            $params['image'] = null;
        }

        $params['is_active'] = $request->has('is_active') ? 1 : 0;
        Voucher::create($params);

        return back()->with('statusSuccess', 'Thêm danh mục thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vouchers = Voucher::query()->findOrFail($id);
        return view('admin.vouchers.edit', compact('vouchers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $vouchers = Voucher::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($vouchers->image && Storage::disk('public')->exists($vouchers->image)) {
                    Storage::disk('public')->delete($vouchers->image);
                }

                $name = $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('uploads/vouchers/images', $name, 'public');

                $params['image'] = $name;
            } else {
                $params['image'] = $vouchers->image;
            }
            $params['is_active'] = $request->has('is_active') ? 1 : 0;

            $vouchers->update($params);

            return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Cập nhật danh mục thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vouchers = Voucher::findOrFail($id);

        if ($vouchers->image && Storage::disk('public')->exists($vouchers->image)) {
            Storage::disk('public')->delete($vouchers->image);
        }

        $vouchers->delete();

        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Xóa vouchers thành công!');
    }


    public function onActive($id)
    {

        // Bật banner được chọn
        $vouchers = Voucher::find($id);
        $vouchers->is_active = 1;
        $vouchers->save();


        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Banner đã được bật');
    }

    public function offActive($id)
    {

        $voucher = Voucher::find($id);
        $voucher->is_active = 0;
        $voucher->save();

        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Banner đã được tắt');
    }
}
