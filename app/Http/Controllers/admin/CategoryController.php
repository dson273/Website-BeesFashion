<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::whereNull('parent_category_id')->get();
        return view('admin.categories.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cate_parent = $this->getCategoriesProduct();
        return view('admin.categories.create', compact('cate_parent'));
    }

    public function getCategoriesProduct()
    {
        $cate_parent = Category::where('is_active', 1)->get();
        $listCate = [];
        Category::recursive($cate_parent, $parents = 0, $level = 1, $listCate);
        return $listCate;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/imgcate', 'public');
            } else {
                $params['image'] = null;
            }
            Category::create($params);

            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $parentCategory = Category::findOrFail($id);

        // Lấy tất cả danh mục con có parent_category_id bằng ID của danh mục cha
        $childCategories = Category::where('parent_category_id', $parentCategory->id)->get();
        return view('admin.categories.detail', compact('parentCategory', 'childCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cate_parent = $this->getCategoriesProduct();
        $sub_parent = Category::where('parent_category_id', $id)->pluck('id')->toArray();
        $Cate = Category::query()->findOrFail($id);
        return view('admin.categories.edit', compact('Cate', 'cate_parent', 'sub_parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $Cate = Category::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($Cate->image && Storage::disk('public')->exists($Cate->image)) {
                    Storage::disk('public')->delete($Cate->image);
                }

                $name = $request->file('image')->store('uploads/imgcate', 'public');

                $params['image'] = $name;
            } else {
                $params['image'] = $Cate->image;
            }

            $Cate->update($params);

            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Cate = Category::findOrFail($id);

        $childCategories = Category::where('parent_category_id', $Cate->id)->count();
        if ($childCategories > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xóa danh mục vì có danh mục con.');
        }

        if ($Cate->image && Storage::disk('public')->exists($Cate->image)) {
            Storage::disk('public')->delete($Cate->image);
        }

        $Cate->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
