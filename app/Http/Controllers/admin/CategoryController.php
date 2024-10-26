<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::whereNull('parent_category_id')
            ->orderBy('created_at', 'desc')
            ->get();
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



    public function getProductsByCategory($id)
    {
        // Lấy danh mục theo ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Lấy tất cả sản phẩm liên quan đến danh mục này thông qua bảng product_categories
        $products = $category->product_categories()->with('product')->get();

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
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
                $request->file('image')->storeAs('uploads/imgcate', $imageName, 'public');
                // Lưu chỉ tên ảnh vào params
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;
            }
            Category::create($params);

            return back()->with('statusSuccess', 'Thêm danh mục thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $cate_parent = $this->getCategoriesProduct();
        $parentCategory = Category::findOrFail($id);

        // Lấy tất cả danh mục con có parent_category_id bằng ID của danh mục cha
        $childCategories = Category::where('parent_category_id', $parentCategory->id)->get();
        return view('admin.categories.detail', compact('parentCategory', 'childCategories','cate_parent'));
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

                $name = $request->file('image')->getClientOriginalName();
                // Lưu ảnh vào thư mục 'uploads/imgcate'
                $request->file('image')->storeAs('uploads/imgcate', $name, 'public');

                $params['image'] = $name;
            } else {
                $params['image'] = $Cate->image;
            }

            $Cate->update($params);

            return redirect()->route('admin.categories.index')->with('statusSuccess', 'Cập nhật danh mục thành công');
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
            return redirect()->route('admin.categories.index')->with('statusError', 'Không thể xóa danh mục vì có danh mục con.');
        }

        if ($Cate->image && Storage::disk('public')->exists($Cate->image)) {
            Storage::disk('public')->delete($Cate->image);
        }

        $Cate->delete();

        return redirect()->route('admin.categories.index')->with('statusSuccess', 'Xóa danh mục thành công!');
    }

    public function product()
    {
        // Lấy danh mục bán chạy
        $bestSellingCategory = Category::where('fixed', 0)->first();
        // Lấy tất cả sản phẩm thuộc danh mục bán chạy
        $bestSellingProducts = $bestSellingCategory ? $bestSellingCategory->products : [];

        // Lấy tất cả sản phẩm
        $allProducts = Product::where('is_active', 1)->get();

        $bestSellingProductIds = $bestSellingProducts->pluck('id')->toArray();
        return view('admin.categories.topproduct', compact('allProducts', 'bestSellingCategory', 'bestSellingProducts','bestSellingProductIds'));
    }

    public function updateBestSelling(Request $request)
    {
        $bestSellingCategory = Category::where('fixed', 0)->first();

        // Kiểm tra nếu có danh mục bán chạy và có sản phẩm được chọn
        if ($bestSellingCategory && $request->has('product_ids')) {
            // Lấy danh sách ID sản phẩm được chọn
            $productIds = $request->input('product_ids');

            // Gắn các sản phẩm vào danh mục bán chạy
            // Tạo mảng dữ liệu cho việc chèn
            $Data = [];
            foreach ($productIds as $productId) {
                $Data[] = [
                    'product_id' => $productId,
                    'category_id' => $bestSellingCategory->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Chèn dữ liệu vào bảng trung gian
            $bestSellingCategory->product_categories()->insert($Data);

            return back()->with('statusSuccess', 'Sản phẩm đã được thêm vào danh mục bán chạy.');
        }

        return back()->with('statusError', 'Không có sản phẩm nào được chọn.');
    }

    public function remove($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            // Gỡ sản phẩm khỏi danh mục bán chạy
            $product->categories()->detach(); // Gỡ tất cả danh mục liên quan

            return back()->with('statusSuccess', 'Sản phẩm đã được gỡ khỏi danh mục bán chạy.');
        }

        return back()->with('statusError', 'Không tìm thấy danh mục bán chạy.');
    }
}
