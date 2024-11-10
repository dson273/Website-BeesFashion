<?php

namespace App\Http\Controllers\user;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_file;
use App\Models\Product_variant;

class FilterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //cũ
    // public function index(Request $request)
    // {
    //     // Lấy tất cả các danh mục cha cùng các danh mục con của chúng
    //     $listCategory = Category::whereNull('parent_category_id')->with('categoryChildrent')->get();

    //     // Lấy danh sách sản phẩm kèm theo danh mục và thương hiệu của sản phẩm
    //     $listProduct = Product::with(['categories', 'brand'])->get();
    //     $listBrand = Brand::all();
    //     // Kiểm tra nếu yêu cầu là Ajax, trả về JSON cho Ajax
    //     if ($request->ajax()) {
    //         return response()->json(['listProduct' => $listProduct]);
    //     }
    //     $products = Product::where('is_active', 1)->with('product_variants')->get(); // Lấy sản phẩm và các biến thể của nó

    //     $minPriceProduct = null;
    //     $maxPriceProduct = null;

    //     foreach ($products as $product) {
    //         // Lấy tất cả các biến thể của sản phẩm hiện tại
    //         $product_variants = $product->product_variants; // Đã được eager loading

    //         foreach ($product_variants as $product_variant) {
    //             // Lấy giá bán hoặc giá nhập (nếu giá bán không có)
    //             $currentPrice = $product_variant->sale_price ?: $product_variant->display_import_price;

    //             // Thiết lập giá nhỏ nhất và lớn nhất ban đầu
    //             if (is_null($minPriceProduct) || $currentPrice < $minPriceProduct) {
    //                 $minPriceProduct = $currentPrice;
    //             }
    //             if (is_null($maxPriceProduct) || $currentPrice > $maxPriceProduct) {
    //                 $maxPriceProduct = $currentPrice;
    //             }
    //         }
    //     }
    //     // dd($minPriceProduct);

    //     // Trả về view cùng với các biến dữ liệu
    //     return view('user.filterProduct', compact('listCategory', 'listProduct', 'listBrand', 'maxPriceProduct', 'minPriceProduct'));
    // }
    //mới
    public function index(Request $request)
    {
        // Lấy tất cả các danh mục cha cùng các danh mục con của chúng
        $listCategory = Category::whereNull('parent_category_id')->with('categoryChildrent')->get();

        // Lấy danh sách sản phẩm kèm theo danh mục và thương hiệu của sản phẩm
        $listProduct = Product::with(['categories', 'brand'])->get();
        $listBrand = Brand::all();

        // Kiểm tra nếu yêu cầu là Ajax, trả về JSON cho Ajax
        if ($request->ajax()) {
            return response()->json(['listProduct' => $listProduct]);
        }
        $img = Product_file::where('is_default',1);
        // Lấy sản phẩm và các biến thể của nó
        $products = Product::where('is_active', 1)->with('product_variants')->get();

        // Tính toán giá nhỏ nhất và lớn nhất của các sản phẩm
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Trả về view cùng với các biến dữ liệu
        return view('user.filterProduct', compact('listCategory', 'listProduct', 'listBrand', 'maxPriceProduct', 'minPriceProduct'));
    }



    public function getMinMaxPriceProduct()
    {
        $products = Product::where('is_active', 1)->get();
        if ($products) {
            $minPriceProduct = 0;
            $maxPriceProduct = 0;
            foreach ($products as $key => $product) {
                $product_variants = Product_variant::where('product_id', $product->id)->get();
                if ($product_variants) {
                    $minPriceProductVariant = 0;
                    $maxPriceProductVariant = 0;

                    foreach ($product_variants as $key => $product_variant) {
                        if ($key == 0) {
                            if ($product_variant->sale_price != '') {
                                $minPriceProductVariant = $product_variant->sale_price;
                                $maxPriceProductVariant = $product_variant->sale_price;
                            } else {
                                $minPriceProductVariant = $product_variant->display_import_price;
                                $maxPriceProductVariant = $product_variant->display_import_price;
                            }
                        } else {
                            if ($product_variant->sale_price != '' && $product_variant->sale_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price != '' && $product_variant->sale_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->display_import_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->display_import_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->display_import_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->display_import_price;
                            }
                        }
                    }
                    if ($key == 0) {
                        $minPriceProduct = $minPriceProductVariant;
                        $maxPriceProduct = $maxPriceProductVariant;
                    } else {
                        if ($minPriceProduct != 0 && $minPriceProduct > $minPriceProductVariant) {
                            $minPriceProduct = $minPriceProductVariant;
                        }
                        if ($maxPriceProduct != 0 && $maxPriceProduct < $maxPriceProductVariant) {
                            $maxPriceProduct = $maxPriceProductVariant;
                        }
                    }
                }
            }
            $response = [
                'status' => 200,
                'message' => 'Get min max price product successfully!',
                'data' => [
                    'minPrice' => $minPriceProduct,
                    'maxPrice' => $maxPriceProduct
                ]
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 400,
                'message' => 'Get min max price product error!',
            ];
            return response()->json($response);
        }
    }
    //cũ
    // public function filterProduct(Request $request)
    // {
    //     // Khởi tạo query cho sản phẩm
    //     $query = Product::where('is_active', 1);

    //     // Lọc theo tên sản phẩm nếu có
    //     if (!empty($request->name)) {
    //         $query->where('name', 'like', '%' . $request->name . '%');
    //     }

    //     // Lọc theo danh mục nếu có
    //     if (!empty($request->categories)) {
    //         $categoryIds = explode(',', $request->categories);
    //         $query->whereHas('categories', function ($q) use ($categoryIds) {
    //             $q->whereIn('category_id', $categoryIds);
    //         });
    //     }

    //     // Lọc theo thương hiệu nếu có
    //     if (!empty($request->brands)) {
    //         $brandIds = explode(',', $request->brands);
    //         $query->whereIn('brand_id', $brandIds);
    //     }

    //     $minPrice = $request->input('min_price');
    //     $maxPrice = $request->input('max_price');

    //     // Nếu có yêu cầu lọc theo giá, áp dụng điều kiện vào truy vấn
    //     if ($minPrice !== null || $maxPrice !== null) {
    //         $query->whereHas('product_variants', function ($q) use ($minPrice, $maxPrice) {
    //             if ($minPrice !== null) {
    //                 $q->where(function ($subQuery) use ($minPrice) {
    //                     // Kiểm tra sale_price hoặc display_import_price
    //                     $subQuery->where('sale_price', '>=', $minPrice)
    //                         ->orWhere('display_import_price', '>=', $minPrice);
    //                 });
    //             }
    //             if ($maxPrice !== null) {
    //                 $q->where(function ($subQuery) use ($maxPrice) {
    //                     // Kiểm tra sale_price hoặc display_import_price
    //                     $subQuery->where('sale_price', '<=', $maxPrice)
    //                         ->orWhere('display_import_price', '<=', $maxPrice);
    //                 });
    //             }
    //         });
    //     }

    //     // Lấy danh sách sản phẩm sau khi lọc
    //     $products = $query->with('product_variants')->get();

    //     // Khởi tạo giá trị min và max cho tất cả các sản phẩm
    //     $minPriceProduct = null;
    //     $maxPriceProduct = null;

    //     foreach ($products as $product) {
    //         // Tính giá nhỏ nhất và lớn nhất của từng biến thể sản phẩm
    //         $minVariantPrice = $product->product_variants->min(function ($variant) {
    //             // Lấy sale_price nếu có, nếu không lấy display_import_price
    //             return $variant->sale_price ?? $variant->display_import_price;
    //         });

    //         $maxVariantPrice = $product->product_variants->max(function ($variant) {
    //             // Lấy sale_price nếu có, nếu không lấy display_import_price
    //             return $variant->sale_price ?? $variant->display_import_price;
    //         });

    //         // Cập nhật giá nhỏ nhất và lớn nhất toàn cục
    //         if ($minPriceProduct === null || ($minVariantPrice !== null && $minVariantPrice < $minPriceProduct)) {
    //             $minPriceProduct = $minVariantPrice;
    //         }
    //         if ($maxPriceProduct === null || ($maxVariantPrice !== null && $maxVariantPrice > $maxPriceProduct)) {
    //             $maxPriceProduct = $maxVariantPrice;
    //         }

    //         // Gán giá trị nhỏ nhất và lớn nhất cho sản phẩm
    //         $product->variant_sale_price_min = $minVariantPrice;
    //         $product->variant_sale_price_max = $maxVariantPrice;
    //     }

    //     // Trả về kết quả
    //     return response()->json([
    //         'listProduct' => $products,
    //         'min_price_product' => $minPriceProduct,
    //         'max_price_product' => $maxPriceProduct,
    //     ]);
    // }
    //mới
    public function filterProduct(Request $request)
    {
        $query = Product::where('is_active', 1);

        // Lọc theo tên sản phẩm nếu có
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo danh mục nếu có
        if ($request->has('categories') && $request->categories) {
            $categoryIds = explode(',', $request->categories);
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }

        // Lọc theo thương hiệu nếu có
        if ($request->has('brands') && $request->brands) {
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Lọc theo giá nếu có
        if ($request->has('min_price') || $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;

            $query->whereHas('product_variants', function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice) {
                    $q->where('sale_price', '>=', $minPrice)
                        ->orWhere('display_import_price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $q->where('sale_price', '<=', $maxPrice)
                        ->orWhere('display_import_price', '<=', $maxPrice);
                }
            });
        }

        // Lấy các sản phẩm đã lọc và tính toán giá min/max
        $products = $query->with('product_variants')->get();
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        return response()->json([
            'listProduct' => $products,
            'min_price_product' => $minPriceProduct,
            'max_price_product' => $maxPriceProduct,
        ]);
    }

    private function calculatePriceRange($products)
    {
        $minPriceProduct = null;
        $maxPriceProduct = null;

        foreach ($products as $product) {
            $product_variants = $product->product_variants;
            $minVariantPrice = null;
            $maxVariantPrice = null;

            foreach ($product_variants as $variant) {
                $variantSalePrice = $variant->sale_price ?: $variant->display_import_price;

                if ($variantSalePrice) {
                    $minVariantPrice = $minVariantPrice === null ? $variantSalePrice : min($minVariantPrice, $variantSalePrice);
                    $maxVariantPrice = $maxVariantPrice === null ? $variantSalePrice : max($maxVariantPrice, $variantSalePrice);
                }
            }

            // Cập nhật giá min/max của sản phẩm
            $minPriceProduct = $minPriceProduct === null ? $minVariantPrice : min($minPriceProduct, $minVariantPrice);
            $maxPriceProduct = $maxPriceProduct === null ? $maxVariantPrice : max($maxPriceProduct, $maxVariantPrice);

            // Lưu giá min/max của mỗi sản phẩm
            $product->variant_sale_price_min = $minVariantPrice;
            $product->variant_sale_price_max = $maxVariantPrice;
        }

        return [$minPriceProduct, $maxPriceProduct];
    }









    //cũ
    // public function getAllProducts()
    // {
    //     // Lấy tất cả sản phẩm từ bảng Product
    //     $products = Product::all();

    //     // Lấy tất cả biến thể sản phẩm từ bảng Product_variant
    //     $product_variants = Product_variant::all()->groupBy('product_id');

    //     // Khởi tạo biến để lưu giá nhỏ nhất và lớn nhất
    //     $sale_price_min = null;
    //     $sale_price_max = null;

    //     foreach ($products as $product) {
    //         if ($product_variants->has($product->id)) {
    //             $variants = $product_variants[$product->id];

    //             // Tìm giá nhỏ nhất và lớn nhất của biến thể hiện tại
    //             $min_variant_price = $variants->min(function ($variant) {
    //                 return $variant->sale_price ?? $variant->display_import_price;
    //             });
    //             $max_variant_price = $variants->max(function ($variant) {
    //                 return $variant->sale_price ?? $variant->display_import_price;
    //             });

    //             // Gán giá trị này cho thuộc tính của sản phẩm
    //             $product->variant_sale_price_min = $min_variant_price;
    //             $product->variant_sale_price_max = $max_variant_price;

    //             // Cập nhật giá nhỏ nhất và lớn nhất toàn cục
    //             if ($sale_price_min === null || $min_variant_price < $sale_price_min) {
    //                 $sale_price_min = $min_variant_price;
    //             }
    //             if ($sale_price_max === null || $max_variant_price > $sale_price_max) {
    //                 $sale_price_max = $max_variant_price;
    //             }
    //         } else {
    //             // Nếu không có biến thể, gán giá trị mặc định
    //             $product->variant_sale_price_min = null;
    //             $product->variant_sale_price_max = null;
    //         }
    //     }

    //     return response()->json([
    //         'products' => $products,
    //         'sale_price_min' => $sale_price_min,
    //         'sale_price_max' => $sale_price_max
    //     ]);
    // }

    // //1
    // public function getAllProducts()
    // {
    //     // Lấy tất cả các sản phẩm đang hoạt động
    //     $products = Product::where('is_active', 1)->with('product_variants')->get();

    //     // Khởi tạo biến để lưu giá nhỏ nhất và lớn nhất toàn cục
    //     $minPriceProduct = null;
    //     $maxPriceProduct = null;

    //     foreach ($products as $product) {
    //         $product_variants = $product->product_variants;

    //         // Tính giá nhỏ nhất và lớn nhất trong các biến thể của sản phẩm
    //         $minVariantPrice = null;
    //         $maxVariantPrice = null;

    //         foreach ($product_variants as $variant) {
    //             // Kiểm tra nếu có sale_price, nếu không thì dùng display_import_price
    //             $variantPrice = $variant->sale_price ?? $variant->display_import_price;

    //             // Cập nhật giá nhỏ nhất và lớn nhất của sản phẩm
    //             if ($minVariantPrice === null || $variantPrice < $minVariantPrice) {
    //                 $minVariantPrice = $variantPrice;
    //             }
    //             if ($maxVariantPrice === null || $variantPrice > $maxVariantPrice) {
    //                 $maxVariantPrice = $variantPrice;
    //             }
    //         }

    //         // Gán giá trị nhỏ nhất và lớn nhất cho sản phẩm
    //         $product->variant_sale_price_min = $minVariantPrice;
    //         $product->variant_sale_price_max = $maxVariantPrice;

    //         // Cập nhật giá nhỏ nhất và lớn nhất toàn cục
    //         if ($minPriceProduct === null || $minVariantPrice < $minPriceProduct) {
    //             $minPriceProduct = $minVariantPrice;
    //         }
    //         if ($maxPriceProduct === null || $maxVariantPrice > $maxPriceProduct) {
    //             $maxPriceProduct = $maxVariantPrice;
    //         }
    //     }

    //     // Trả về kết quả với danh sách sản phẩm và giá nhỏ nhất, lớn nhất
    //     return response()->json([
    //         'products' => $products,
    //         'minPrice' => $minPriceProduct,
    //         'maxPrice' => $maxPriceProduct
    //     ]);
    // }
    //mới
    public function getAllProducts()
    {
        $products = Product::where('is_active', 1)->with('product_variants')->get();
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        return response()->json([
            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
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
