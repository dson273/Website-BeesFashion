<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listBrand = Brand::get();
        // dd($listBrand);
        return view('admin.brands.index',compact('listBrand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brands.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        //
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image')) {
                // Lấy tên ảnh
                $imageName = $request->file('image')->getClientOriginalName();
                // Lưu ảnh vào thư mục 'uploads/imgcate'
                $request->file('image')->storeAs('uploads/imgbrand', $imageName, 'public');
                // Lưu chỉ tên ảnh vào params
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;
            }
            Brand::create($params);

            return view('admin.brands.index')->with('statusSuccess', 'Thêm thương hiệu thành công');
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
        $brandID = Brand::query()->findOrFail($id);
        return view('admin.brands.edit', compact('brandID'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $brandID = Brand::query()->findOrFail($id);

            if ($request->hasFile('image')) {
                if ($brandID->image && Storage::disk('public')->exists($brandID->image)) {
                    Storage::disk('public')->delete($brandID->image);
                }

                $name = $request->file('image')->getClientOriginalName();
                // Lưu ảnh vào thư mục 'uploads/imgbrandID'
                $request->file('image')->storeAs('uploads/imgbrand', $name, 'public');

                $params['image'] = $name;
            } else {
                $params['image'] = $brandID->image;
            }

            $brandID->update($params);

            return redirect()->route('admin.brands.index')->with('statusSuccess', 'Cập nhật thương hiệu thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $brandID = Brand::findOrFail($id);

        $childCategories = Brand::where('parent_category_id', $brandID->id)->count();

        if ($brandID->image && Storage::disk('public')->exists($brandID->image)) {
            Storage::disk('public')->delete($brandID->image);
        }

        $brandID->delete();

        return redirect()->route('admin.categories.index')->with('statusSuccess', 'Xóa thương hiệu thành công!');
    }
}
