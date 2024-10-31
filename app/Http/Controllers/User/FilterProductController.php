<?php

namespace App\Http\Controllers\user;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_file;
use App\Models\Product_variant;

class FilterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listCategory = Category::all(); // Lấy tất cả danh mục
        $cate_parent = Category::all(); //danh mục con
        $listCate = [];
        // Tạo query để lấy sản phẩm
        $query = Product::with('categories');
        // Lấy danh sách sản phẩm đã lọc
        $listProduct = $query->get();
        // Gọi phương thức đệ quy để lấy danh sách danh mục
        Category::recursive($cate_parent, 0, 1, $listCate);
        // Kiểm tra nếu yêu cầu là Ajax, trả về JSON cho Ajax
        if ($request->ajax()) {
            return response()->json(['listProduct' => $listProduct]);
        }
        // Trả về view cùng với các biến dữ liệu
        return view('user.filterProduct', compact('listCate', 'listCategory', 'listProduct'));
    }



    public function filterProduct(Request $request)
    {
        // Khởi tạo query
        $query = Product::query();

        // Lọc theo tên sản phẩm nếu có
        if (!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo danh mục nếu có
        if (!empty($request->categories)) {
            $categoryIds = explode(',', $request->categories);
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }

        // Lọc theo giá nếu có giá trị min_price và max_price
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($minPrice !== null && $maxPrice !== null) {
            // Chỉ áp dụng lọc giá nếu cả minPrice và maxPrice đều hợp lệ
            $query->whereHas('product_variants', function ($q) use ($minPrice, $maxPrice) {
                $q->where('sale_price', '>=', $minPrice)
                    ->where('sale_price', '<=', $maxPrice);
            });
        }

        // Thực hiện truy vấn và trả về kết quả
        $listProduct = $query->get();

        return response()->json(['listProduct' => $listProduct]);
    }





    public function getAllProducts()
    {
        // Lấy tất cả sản phẩm từ bảng Product
        $products = Product::all();

        // Lấy tất cả biến thể sản phẩm từ bảng Product_variant
        $product_variants = Product_variant::all()->keyBy('product_id');
        foreach ($products as $product) {
            if ($product_variants->has($product->id)) {
                $product->variant_price = $product_variants[$product->id]->sale_price; // Hoặc gán các thuộc tính khác nếu cần
            } else {
                $product->variant_price = null; // Hoặc giá mặc định
            }
        }
        return response()->json($products);
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
        //
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

    public function getProductsByCategory($id)
    {
        // Lấy danh mục theo ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Lấy tất cả sản phẩm liên quan đến danh mục này thông qua bảng product_categories
        $products = $category->products()->with('product_categories')->get();

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
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
