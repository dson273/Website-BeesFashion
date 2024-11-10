<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product_variant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_variant_attribute_value;

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

    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }
}
