<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.vouchers.index');
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
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image')) {
                // Lấy tên ảnh
                $imageName = $request->file('image')->getClientOriginalName();
                // Lưu ảnh vào thư mục 'uploads/imgcate'
                $request->file('image')->storeAs('uploads/vouchers/images', $imageName, 'public');
                // Lưu chỉ tên ảnh vào params
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;
            }

            $params['is_active'] = $request->has('is_active') ? 1 : 0;
            Voucher::create($params);

            return back()->with('statusSuccess', 'Thêm danh mục thành công');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
