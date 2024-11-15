<?php

namespace App\Http\Controllers\user;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute_value;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_file;
use App\Models\Product_category;
use App\Models\Product_variant;

class FilterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        function priceProduct($product)
        {
            // Lấy giá sale và giá nhập của sản phẩm từ product_variants
            $salePrices = $product->product_variants->pluck('sale_price');
            $importPrices = $product->product_variants->pluck('regular_price');

            $minSalePrice = $salePrices->min();
            $maxSalePrice = $salePrices->max();
            $minImportPrice = $importPrices->min();
            $maxImportPrice = $importPrices->max();

            // Kiểm tra và trả về giá
            if ($salePrices->every(fn($price) => $price === null)) {
                // Tất cả sale_price đều là null
                return "$" . number_format($minImportPrice) . " - $" . number_format($maxImportPrice);
            } elseif ($salePrices->contains(null)) {
                // Có sale_price là null
                if ($minSalePrice === null) {
                    return "$" . number_format($minImportPrice) . " - $" . number_format($maxSalePrice);
                } elseif ($maxSalePrice === null) {
                    return "$" . number_format($minSalePrice) . " - $" . number_format($maxImportPrice);
                } else {
                    return "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
                }
            } else {
                // Tất cả có sale_price
                return "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
            }
        }

        // Lấy danh sách các danh mục cha
        $listCategory = Category::whereNull('parent_category_id')->where('categories.fixed', 1)->with('categoryChildrent')->get();

        // Lấy danh sách sản phẩm và danh sách thương hiệu
        $listProduct = Product::with(['categories', 'brand'])->get();
        $listBrand = Brand::all();

        // Lấy danh sách màu sắc (attributes) cho sản phẩm
        $listColor = Attribute_value::all();


        $productsQuery = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.fixed', 0)
            ->where('products.is_active', 1) // Lọc sản phẩm đang hoạt động
            ->with(['product_files', 'product_variants'])
            ->select('products.*');
        if ($request->has('brand_id')) {
            $productsQuery->where('brand_id', $request->brand_id);
        }

        $products = $productsQuery->paginate(12);
        $minPriceProduct = $products->map(function ($product) {
            return priceProduct($product);
        })->min();
        $maxPriceProduct = $products->map(function ($product) {
            return priceProduct($product);
        })->max();
        return view('user.filterProduct', compact(
            'listCategory',
            'listProduct',
            'listBrand',
            'maxPriceProduct',
            'minPriceProduct',
            'listColor',
            'products' // Truyền danh sách sản phẩm đã phân trang
        ));
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
                                $minPriceProductVariant = $product_variant->regular_price;
                                $maxPriceProductVariant = $product_variant->regular_price;
                            }
                        } else {
                            if ($product_variant->sale_price != '' && $product_variant->sale_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price != '' && $product_variant->sale_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->regular_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->regular_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->regular_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->regular_price;
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

    public function filterProduct(Request $request)
    {
        $query = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image');

        if ($request->has('color') && $request->color != '') {
            $query->whereHas('product_files', function ($query) use ($request) {
                $query->where('value', $request->color); // Lọc theo màu
            });
        }

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
        // Lấy các sản phẩm đã lọc và tính toán giá min/max
        if ($request->has('min_price') || $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;

            $query->whereHas('product_variants', function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice) {
                    $q->where('sale_price', '>=', $minPrice)
                        ->orWhere('regular_price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $q->where('sale_price', '<=', $maxPrice)
                        ->orWhere('regular_price', '<=', $maxPrice);
                }
            });
        }

        $products = $query->get()->map(function ($product) {
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }
            return $product;
        });
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
                $variantPrice = $variant->sale_price ? $variant->sale_price : $variant->regular_price;

                $minVariantPrice = $minVariantPrice === null ? $variantPrice : min($minVariantPrice, $variantPrice);
                $maxVariantPrice = $maxVariantPrice === null ? $variantPrice : max($maxVariantPrice, $variantPrice);
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

    public function getAllProducts()
    {
        $products = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->get();

        // Tính toán giá trị min và max
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['product' => $product->id]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }

            return $product;
        });
        $products = $products->map(function ($product) {
            $product->productID = route('product.detail', ['product' => $product->id]);
            return $product;
        });

        return response()->json([

            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getBestSellingProducts()
    {


        $products = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('categories.fixed', 0)
            ->with(['product_files', 'product_variants'])
            ->select('products.*', 'product_files.file_name as image')
            ->get();
        // Tính toán giá trị min và max từ các sản phẩm
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['product' => $product->id]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }

            return $product;
        });

        // Trả về dữ liệu JSON
        return response()->json([
            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getProductDetails($id)
    {
        // Lấy thông tin sản phẩm
        $product = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.id', $id)
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->first();

        // Nếu không tìm thấy sản phẩm
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Xử lý các hình ảnh sản phẩm
        $productImages = Product_file::where('product_id', $product->id)
            ->where('file_type', 'image')
            ->get();

        $imageUrls = $productImages->map(function ($image) {
            return asset('uploads/products/images/' . $image->file_name);
        });

        // Trả về dữ liệu sản phẩm cùng với danh sách hình ảnh
        return response()->json([
            'product' => [
                'name' => $product->name,
                'price' => $product->price,
                'old_price' => $product->old_price,
                'description' => $product->description,
                'images' => $imageUrls, // Trả về danh sách ảnh
                'sizes' => ['S', 'M', 'L', 'XL'], // Ví dụ về kích thước (nên lấy từ cơ sở dữ liệu)
                'colors' => ['red', 'blue', 'green'], // Ví dụ về màu sắc (nên lấy từ cơ sở dữ liệu)
            ],
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


    public function sortProducts(Request $request)
    {
        // Mặc định sắp xếp theo "Sản phẩm bán chạy"
        $sortBy = $request->input('sort_by', 'best_selling');

        $query = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image');
        // Tạo query builder để lấy danh sách sản phẩm

        switch ($sortBy) {
            case 'alphabetical_desc':
                $query->orderByDesc('name');
                break;
            default:
                // Sắp xếp theo mặc định (sản phẩm bán chạy hoặc tiêu chí khác)
                $query->orderByDesc('sales_count');
                break;
        }

        // Lấy danh sách sản phẩm đã sắp xếp
        $products = $query->get();

        // Trả về kết quả dưới dạng JSON để cập nhật giao diện người dùng
        return response()->json([
            'products' => $products
        ]);
    }

    // public function showProductDetails($id)
    // {
    //     $product = Product::with(['images', 'sizes', 'colors'])->findOrFail($id);  // Tải thông tin sản phẩm và các mối quan hệ

    //     return response()->json([
    //         'product' => $product
    //     ]);
    // }

    public function getColor() {}
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
