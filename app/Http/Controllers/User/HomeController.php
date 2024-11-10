<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Trang chủ
    public function index()
    {

        function priceProduct($product)
        {
            $salePrices = $product->product_variants->pluck('sale_price');
            $importPrices = $product->product_variants->pluck('regular_price');

            $minSalePrice = $salePrices->min();
            $maxSalePrice = $salePrices->max();
            $minImportPrice = $importPrices->min();
            $maxImportPrice = $importPrices->max();

            if ($salePrices->every(fn($price) => $price === null)) {
                // Tất cả sale_price đều là null
                return "$" . number_format($minImportPrice) . " - $" . number_format($maxImportPrice);
            } elseif ($salePrices->contains(null)) {
                // Có sale_price null
                if ($minSalePrice === null) {
                    return $maxSalePrice === $minImportPrice
                        ? "$" . number_format($maxSalePrice)
                        : "$" . number_format($minImportPrice) . " - $" . number_format($maxSalePrice);
                } elseif ($maxSalePrice === null) {
                    return $minSalePrice === $maxImportPrice
                        ? "$" . number_format($minSalePrice)
                        : "$" . number_format($minSalePrice) . " - $" . number_format($maxImportPrice);
                } else {
                    return $minImportPrice === $maxSalePrice
                        ? "$" . number_format($minImportPrice)
                        : "$" . number_format($maxSalePrice) . " - $" . number_format($maxImportPrice);
                }
            } else {
                // Có sale_price cho tất cả
                if ($minSalePrice === $maxSalePrice || $minSalePrice === $maxImportPrice || $maxSalePrice === $minImportPrice) {
                    return "$" . number_format(min($minSalePrice, $maxSalePrice, $minImportPrice, $maxImportPrice));
                }
                return "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
            }
        }


        $sliders  = Banner::where('is_active', 1)
            ->with('banner_images') // Load các hình ảnh liên quan
            ->get();

        $topProducts = Product::with(['product_files'])
            ->orderBy('view', 'DESC')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $product->priceRange = priceProduct($product);
                return $product;
            });
        $newProducts = Product::with(['product_files'])
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $salePrices = $product->product_variants->pluck('sale_price'); // Lấy giá sale_price của tất cả biến thể
                $importPrices = $product->product_variants->pluck('display_import_price'); // Lấy giá display_import_price

                $minSalePrice = $salePrices->min(); // Giá sale thấp nhất
                $maxSalePrice = $salePrices->max(); // Giá sale cao nhất

                $minImportPrice = $importPrices->min(); // Giá nhập thấp nhất
                $maxImportPrice = $importPrices->max(); // Giá nhập cao nhất

                // Điều kiện hiển thị giá
                if ($salePrices->every(function ($price) {
                    return $price === null;
                })) {
                    // Tất cả sale_price đều là null
                    $product->priceRange = "$" . number_format($minImportPrice) . " - $" . number_format($maxImportPrice);
                } elseif ($salePrices->contains(null)) {
                    if ($minSalePrice === null) {
                        // Giá sale_price thấp nhất là null
                        if ($maxSalePrice === $minImportPrice) {
                            $product->priceRange = "$" . number_format($maxSalePrice);
                        } else {
                            $product->priceRange = "$" . number_format($minImportPrice) . " - $" . number_format($maxSalePrice);
                        }
                    } elseif ($maxSalePrice === null) {
                        // Giá sale_price cao nhất là null
                        if ($minSalePrice === $maxImportPrice) {
                            $product->priceRange = "$" . number_format($minSalePrice);
                        } else {
                            $product->priceRange = "$" . number_format($minSalePrice) . " - $" . number_format($maxImportPrice);
                        }
                    } else {
                        // Có sale_price nhưng có giá null
                        if ($minImportPrice === $maxSalePrice) {
                            $product->priceRange = "$" . number_format($minImportPrice);
                        } else {
                            $product->priceRange = "$" . number_format($maxSalePrice) . " - $" . number_format($maxImportPrice);
                        }
                    }
                } else {
                    // Có sale_price cho tất cả
                    if ($minSalePrice === $maxSalePrice) {
                        // Giá sale_price đều bằng nhau
                        $product->priceRange = "$" . number_format($minSalePrice);
                    } elseif ($minSalePrice === $maxImportPrice) {
                        // Giá sale_price thấp nhất bằng giá display_import_price cao nhất
                        $product->priceRange = "$" . number_format($minSalePrice);
                    } elseif ($maxSalePrice === $minImportPrice) {
                        // Giá sale_price cao nhất bằng giá display_import_price thấp nhất
                        $product->priceRange = "$" . number_format($maxSalePrice);
                    } else {
                        // Giá sale_price khác nhau
                        $product->priceRange = "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
                    }
                }

                return $product;
            });
        $products = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.fixed', 0)
            ->with(['product_files', 'product_variants'])
            ->select('products.*')
            ->get()
            ->map(function ($product) {
                $salePrices = $product->product_variants->pluck('sale_price'); // Lấy giá sale_price của tất cả biến thể
                $importPrices = $product->product_variants->pluck('display_import_price'); // Lấy giá display_import_price

                $minSalePrice = $salePrices->min(); // Giá sale thấp nhất
                $maxSalePrice = $salePrices->max(); // Giá sale cao nhất

                $minImportPrice = $importPrices->min(); // Giá nhập thấp nhất
                $maxImportPrice = $importPrices->max(); // Giá nhập cao nhất

                // Điều kiện hiển thị giá
                if ($salePrices->every(function ($price) {
                    return $price === null;
                })) {
                    // Tất cả sale_price đều là null
                    $product->priceRange = "$" . number_format($minImportPrice) . " - $" . number_format($maxImportPrice);
                } elseif ($salePrices->contains(null)) {
                    if ($minSalePrice === null) {
                        // Giá sale_price thấp nhất là null
                        if ($maxSalePrice === $minImportPrice) {
                            $product->priceRange = "$" . number_format($maxSalePrice);
                        } else {
                            $product->priceRange = "$" . number_format($minImportPrice) . " - $" . number_format($maxSalePrice);
                        }
                    } elseif ($maxSalePrice === null) {
                        // Giá sale_price cao nhất là null
                        if ($minSalePrice === $maxImportPrice) {
                            $product->priceRange = "$" . number_format($minSalePrice);
                        } else {
                            $product->priceRange = "$" . number_format($minSalePrice) . " - $" . number_format($maxImportPrice);
                        }
                    } else {
                        // Có sale_price nhưng có giá null
                        if ($minImportPrice === $maxSalePrice) {
                            $product->priceRange = "$" . number_format($minImportPrice);
                        } else {
                            $product->priceRange = "$" . number_format($maxSalePrice) . " - $" . number_format($maxImportPrice);
                        }
                    }
                } else {
                    // Có sale_price cho tất cả
                    if ($minSalePrice === $maxSalePrice) {
                        // Giá sale_price đều bằng nhau
                        $product->priceRange = "$" . number_format($minSalePrice);
                    } elseif ($minSalePrice === $maxImportPrice) {
                        // Giá sale_price thấp nhất bằng giá display_import_price cao nhất
                        $product->priceRange = "$" . number_format($minSalePrice);
                    } elseif ($maxSalePrice === $minImportPrice) {
                        // Giá sale_price cao nhất bằng giá display_import_price thấp nhất
                        $product->priceRange = "$" . number_format($maxSalePrice);
                    } else {
                        // Giá sale_price khác nhau
                        $product->priceRange = "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
                    }
                }

                return $product;
            });

        return view('user.index', compact('sliders', 'topProducts', 'newProducts', 'products'));
    }

    //Trang dashboard người dùng
    public function dashboard()
    {
        return view('user.dashboard');
    }

    //Trang chi tiết sản phẩm
    public function product_detail(string $id)
    {
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute'
        ])->find($id);

        //View tăng lên 1
        if ($product) {
            $product->increment('view');
        }

        // Mảng chứa các biến thể với các attribute_value_id liên quan
        $array_variants = $product->product_variants->map(function ($variant) {
            return [
                'variant_id' => $variant->id,
                'stock' => $variant->stock,
                'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
            ];
        })->toArray();

        // Lấy tất cả các attribute_value_id và attribute_id duy nhất
        $attribute_value_ids = $product->product_variants
            ->pluck('variant_attribute_values.*.attribute_value_id')
            ->flatten()
            ->unique()
            ->toArray();

        $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
            ->pluck('attribute_id')
            ->unique()
            ->sort()
            ->toArray();

        // Xây dựng mảng thuộc tính đã lọc
        $array_attributes = Attribute::with([
            'attribute_values' => function ($query) use ($attribute_value_ids) {
                $query->whereIn('id', $attribute_value_ids);
            },
            'attribute_type' // Lấy thông tin loại thuộc tính
        ])->whereIn('id', $attribute_ids)->get()->mapWithKeys(function ($attribute) {
            return [
                $attribute->id => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'type' => $attribute->attribute_type ? $attribute->attribute_type->type_name : null, // Lấy tên loại thuộc tính
                    'attribute_values' => $attribute->attribute_values->sortBy(function ($value) {
                        // Sắp xếp theo thứ tự "S", "M", "L", "XL", nếu giá trị khác số
                        $sizes = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                        return $sizes[$value->name] ?? $value->name; // Sắp xếp theo thứ tự định trước hoặc theo tên
                    })->values()->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'name' => $value->name,
                            'value' => $value->value
                        ];
                    })->toArray()
                ]
            ];
        })->toArray();
        $productDetail = Product::find($id);

        // dd($array_attributes);

        return view('user.product-detail', compact('product', 'productDetail', 'array_attributes', 'array_variants'));
    }
}
