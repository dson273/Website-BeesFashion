<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Import_history;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_file;
use App\Models\Product_variant;
use App\Models\Product_variant_attribute_value;
use App\Models\Product_vote;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use Mockery\Undefined;

use function Laravel\Prompts\error;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function returnRedirectRouteWithMessage($routeName, $parameter = '', $messageType, $messageContent)
    {
        return redirect()->route($routeName, $parameter)->with($messageType, $messageContent);
    }
    public function index()
    {
        $listProducts = Product::with(['product_variants.order_details.order.status_orders', 'product_files'])
            ->select('products.*')
            ->selectRaw('(
            SELECT COALESCE(SUM(od.quantity), 0) 
            FROM order_details od 
            INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
            INNER JOIN orders o ON od.order_id = o.id
            INNER JOIN status_orders so ON o.id = so.order_id
            WHERE pv.product_id = products.id
            AND so.status_id = 3
        ) as total_sold')
            ->where('is_active', 1)
            ->selectRaw('(
            SELECT file_name 
            FROM product_files 
            WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->get();
        // ==================================
        return view('admin.products.index', compact('listProducts'));
    }
    public function inactive()
    {
        $listProducts = Product::with(['product_variants.order_details.order.status_orders', 'product_files'])
            ->select('products.*')
            ->selectRaw('(
            SELECT COALESCE(SUM(od.quantity), 0) 
            FROM order_details od 
            INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
            INNER JOIN orders o ON od.order_id = o.id
            INNER JOIN status_orders so ON o.id = so.order_id
            WHERE pv.product_id = products.id
            AND so.status_id = 3
        ) as total_sold')
            ->selectRaw('(
            SELECT file_name 
            FROM product_files 
            WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->where('is_active', 0)
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->get();
        // ==================================
        return view('admin.products.index', compact('listProducts'));
    }
    public function changeStatusProduct(Request $request)
    {
        $productId = $request['id'];
        $checkProduct = Product::find($productId);
        if ($checkProduct) {
            $checkProduct->is_active = $checkProduct->is_active == 1 ? 0 : 1;
            $checkProduct->save();
            if ($checkProduct->is_active == 1) {
                return $this->returnRedirectRouteWithMessage('admin.products.index.inactive', '', 'statusSuccess', 'Thay đổi trạng thái thành công!');
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusSuccess', 'Thay đổi trạng thái thành công!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Không tìm thấy sản phẩm cần thay đổi trạng thái!');
        }
    }
    public function changeStatusProductVariant(Request $request)
    {
        $productVariantId = $request['id'];
        $checkProductVariant = Product_variant::find($productVariantId);
        if ($checkProductVariant) {
            $checkProductVariant->is_active = $checkProductVariant->is_active == 1 ? 0 : 1;
            $checkProductVariant->save();
            if ($checkProductVariant->is_active == 1) {
                return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusSuccess', 'Thay đổi trạng thái thành công!');
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusSuccess', 'Thay đổi trạng thái thành công!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusError', 'Không tìm thấy biến thể cần thay đổi trạng thái!');
        }
    }
    public function importingGoods()
    {
        $product_variant_id = request()->input('product_variant_id');
        $quantity = request()->input('quantity');
        $import_price = request()->input('import_price');
        $check_product_variant_by_id = Product_variant::find($product_variant_id);
        if ($check_product_variant_by_id) {
            $importing_good = Import_history::create([
                'quantity' => $quantity,
                'import_price' => $import_price,
                'product_variant_id' => $product_variant_id,
                'user_id' => Auth::check() ? Auth::user()->id : ''
            ]);
            if ($importing_good) {
                $check_product_variant_by_id->stock += $quantity;
                $check_product_variant_by_id->save();
                $response = [
                    'status' => 200,
                    'message' => 'Không tìm thấy biến thể cần nhập thêm hàng!'
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Có lỗi khi nhập hàng, vui lòng thử lại!'
                ];
            }
        } else {
            $response = [
                'status' => 404,
                'message' => 'Không tìm thấy biến thể cần nhập thêm hàng!'
            ];
        }
        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $baseInformation = $request->input('baseInformation');
            $sku = $baseInformation['sku'] ?? null;
            $name = $baseInformation['name'] ?? null;
            $description = $baseInformation['description'] ?? null;
            $status = $baseInformation['status'] ?? null;
            $status = $status ? 1 : 0;
            $brandId = $request->input('brandId');

            if ($sku && $name && $description) {
                $newProduct = Product::create([
                    'SKU' => $sku,
                    'name' => $name,
                    'description' => $description,
                    'brand_id' => $brandId ? $brandId : null,
                    'is_active' => $status
                ]);
                if ($request->hasFile('mainImage')) {
                    $mainImage = $request->file('mainImage');
                    $mainImageNameHashed = $mainImage->hashName();
                    $mainImage->move(public_path('uploads/products/images/'), $mainImageNameHashed);
                    if ($mainImage) {
                        Product_file::create([
                            'file_name' => $mainImageNameHashed,
                            'file_type' => 'image',
                            'is_default' => 1,
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 3. Lấy các hình ảnh khác (images)
                $imagesPaths = [];
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imageHashed = $image->hashName();
                        $image->move(public_path('uploads/products/images/'), $imageHashed);
                        $imagesPaths[] = $imageHashed;
                    }
                }
                if (!empty($imagesPaths)) {
                    foreach ($imagesPaths as $imagePath) {
                        Product_file::create([
                            'file_name' => $imagePath,
                            'file_type' => 'image',
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 4. Lấy các video
                $videosPaths = [];
                if ($request->hasFile('videos')) {
                    foreach ($request->file('videos') as $video) {
                        $videoHashed = $video->hashName();
                        $video->move(public_path('uploads/products/videos/'), $videoHashed);
                        $videosPaths[] = $videoHashed;
                    }
                }
                if (!empty($videosPaths)) {
                    foreach ($videosPaths as $videoPath) {
                        Product_file::create([
                            'file_name' => $videoPath,
                            'file_type' => 'video',
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 5. Lấy các ID của danh mục đã chọn
                $categoriesId = $request->input('categoriesId', []);
                if (!empty($categoriesId)) {
                    foreach ($categoriesId as $item) {
                        Product_category::create([
                            'product_id' => $newProduct->id,
                            'category_id' => $item
                        ]);
                    }
                }

                if ($request->has('variations') && is_array($request->input('variations'))) {
                    // Nếu là mảng, gán nó vào biến
                    $variations = $request->input('variations');
                } else {
                    // Nếu không, thử decode từ JSON (nếu cần)
                    $variations = json_decode($request->input('variations'), true);
                }
                $attributeData = [];
                foreach ($variations as $index => $item) {
                    $skuVariation = $request->input("variations.$index.sku");
                    $nameVariation = $request->input("variations.$index.name");
                    $skuVariation = $skuVariation != '' ? $skuVariation : $newProduct->SKU . '-' . $nameVariation;
                    $importPriceVariation = $request->input("variations.$index.import_price");
                    $regularPriceVariation = $request->input("variations.$index.regular_price");
                    $salePriceVariation = $request->input("variations.$index.sale_price");
                    $stockVariation = $request->input("variations.$index.stock");
                    $activeVariation = $request->input("variations.$index.active") ? 1 : 0;

                    // Kiểm tra và lưu ảnh biến thể nếu tồn tại
                    $imageNameHashed = null;
                    if ($request->hasFile("variations.$index.image_data")) {
                        $imageVariation = $request->file("variations.$index.image_data");
                        $imageNameHashed = $imageVariation->hashName();
                        $imageVariation->move(public_path('uploads/products/images/'), $imageNameHashed);
                    }

                    // Tạo mới Product_variant
                    $newProductVariation = Product_variant::create([
                        'SKU' => $skuVariation,
                        'name' => $nameVariation,
                        'image' => $imageNameHashed,
                        'regular_price' => $regularPriceVariation,
                        'sale_price' => $salePriceVariation,
                        'stock' => $stockVariation,
                        'product_id' => $newProduct->id,
                        'is_active' => $activeVariation
                    ]);

                    // Thêm vào bảng Import_history
                    Import_history::create([
                        'quantity' => $stockVariation,
                        'import_price' => $importPriceVariation,
                        'product_variant_id' => $newProductVariation->id,
                        'user_id' => Auth::check() ? Auth::user()->id : ''
                    ]);

                    // Xử lý dữ liệu variationAttributeData
                    $variationAttributeData = $request->input("variations.$index.variationAttributeData");
                    foreach ($variationAttributeData as $attributeItem) {
                        if (!empty($attributeItem['attributeId'])) {
                            if (!empty($attributeItem['attributeValueId'])) {
                                $checkAttributeValueId = Attribute_value::find($attributeItem['attributeValueId']);
                                if ($checkAttributeValueId) {
                                    Product_variant_attribute_value::create([
                                        'product_variant_id' => $newProductVariation->id,
                                        'attribute_value_id' => $attributeItem['attributeValueId']
                                    ]);
                                }
                            }
                        } else {
                            if ($attributeItem['attributeValue'] && $attributeItem['attributeValue'] != '') {
                                $checkAttribute = false;
                                foreach ($attributeData as $itemAttributeData) {
                                    //Kiểm tra xem thuộc tính hiện tại đã được tạo trong cơ sở dữ liệu chưa
                                    if ($itemAttributeData['attributeName'] == $attributeItem['attributeName']) {
                                        //Nếu đã tồn tại trong cơ sở dữ liệu thì tìm kiếm giá trị thuộc tính hiện tại của nó đã được tạo trong db chưa
                                        $findAttributeValue = Attribute_value::where('name', $attributeItem['attributeValue'])
                                            ->where('attribute_id', $itemAttributeData['attributeId'])->first();
                                        //Nếu đã đc tạo trong db rồi thì tạo một bản ghi ở bảng 'product_variant_attribute_values'
                                        if ($findAttributeValue) {
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $findAttributeValue->id
                                            ]);
                                        } else {
                                            //Nếu giá trị thuộc tính này chưa tồn tại trong thuộc tính hiện tại thì tạo mới nó và thêm 1 bản ghi ở bảng 'product_variant_attribute_values'
                                            $newAttributeValue = Attribute_value::create([
                                                'name' => $attributeItem['attributeValue'],
                                                'attribute_id' => $itemAttributeData['attributeId']
                                            ]);
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $newAttributeValue->id
                                            ]);
                                        }
                                        $checkAttribute = true;
                                        break;
                                    }
                                }
                                if (!$checkAttribute) {
                                    $newAttribute = Attribute::create([
                                        'name' => $attributeItem['attributeName']
                                    ]);
                                    $newAttributeValue = Attribute_value::create([
                                        'name' => $attributeItem['attributeValue'],
                                        'attribute_id' => $newAttribute->id
                                    ]);

                                    $attributeData[] = [
                                        'attributeId' => $newAttribute->id,
                                        'attributeName' => $newAttribute->name
                                    ];

                                    Product_variant_attribute_value::create([
                                        'product_variant_id' => $newProductVariation->id,
                                        'attribute_value_id' => $newAttributeValue->id
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $response = [
                'status' => 200,
                'message' => 'Create product successfully!',
            ];
        } catch (Exception $e) {
            // Xử lý khi có lỗi
            $response = [
                'status' => 400,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productDetail = Product::with([
            'product_variants.order_details.order.status_orders',
            'product_gallery',
            'product_videos'
        ])
            ->select('products.*')
            ->selectRaw('(
                SELECT COALESCE(SUM(od.quantity), 0) 
                FROM order_details od 
                INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
                INNER JOIN orders o ON od.order_id = o.id
                INNER JOIN status_orders so ON o.id = so.order_id
                WHERE pv.product_id = products.id
                AND so.status_id = 3
            ) as total_sold')
            ->selectRaw('(
                SELECT file_name 
                FROM product_files 
                WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->where('id', $id)
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->first();
        $productVariants = Product_variant::with('order_details.order.status_orders')
            ->select('product_variants.*')
            ->selectRaw('(
                SELECT COALESCE(SUM(od.quantity), 0) 
                FROM order_details od 
                INNER JOIN orders o ON od.order_id = o.id
                INNER JOIN status_orders so ON o.id = so.order_id
                WHERE od.product_variant_id = product_variants.id
                AND so.status_id = 3
            ) as total_sold')
            ->where('product_variants.product_id', $id)
            ->get();
        if ($productVariants) {
            $starRatingOfMultipleProductVariants = 0;
            $variantVoted = 0;
            foreach ($productVariants as $variant) {
                $totalProfitPerItem = 0;
                $import_histories = Import_history::where('product_variant_id', $variant->id)->orderBy('created_at', 'asc')->get();
                if ($import_histories) {
                    foreach ($import_histories as $key => $history) {
                        $totalProfitPerTime = 0;
                        $currentTime = $history->created_at;
                        $nextTime = isset($import_histories[$key + 1]) ? $import_histories[$key + 1]->created_at : Carbon::now('Asia/Ho_Chi_Minh');
                        $order_details = Order_detail::with('order.status_orders')
                            ->whereHas('order.status_orders', function ($query) {
                                $query->where('status_id', 3);
                            })
                            ->where('product_variant_id', $variant->id)
                            ->where('created_at', '>=', $currentTime)
                            ->where('created_at', '<', $nextTime)
                            ->get();
                        if ($order_details) {
                            foreach ($order_details as $key => $order_detail) {
                                $totalProfitPerTime += ($order_detail->original_price - $history->import_price) * $order_detail->quantity;
                            }
                        }
                        $totalProfitPerItem += $totalProfitPerTime;
                    }
                }
                $variant->total_profit = $totalProfitPerItem;

                //Get star
                $productVotes = Product_vote::where('product_variant_id', $variant->id)
                    ->where('status', 1)->get();
                if ($productVotes->count() > 0) {
                    $starRatingPerProductVariant = 0;
                    $productVote = 0;
                    foreach ($productVotes as $voteItem) {
                        $productVote += $voteItem->star;
                    }
                    $starRatingPerProductVariant = $productVote / $productVotes->count();
                    $starRatingOfMultipleProductVariants += $starRatingPerProductVariant;
                    $variantVoted++;
                }
            }
            if ($variantVoted > 0) {
                $starRatingOfMultipleProductVariants /= $variantVoted;
            }
            $productStar = $starRatingOfMultipleProductVariants > 0 ? $starRatingOfMultipleProductVariants : 0;
            // dd($starRatingOfMultipleProductVariants);
        }
        if ($productDetail->product_variants) {
            $totalProfit = 0;
            foreach ($productDetail->product_variants as $variant) {
                $totalProfitPerItem = 0;
                $import_histories = Import_history::where('product_variant_id', $variant->id)->orderBy('created_at', 'asc')->get();
                if ($import_histories) {
                    foreach ($import_histories as $key => $history) {
                        $totalProfitPerTime = 0;
                        $currentTime = $history->created_at;
                        $nextTime = isset($import_histories[$key + 1]) ? $import_histories[$key + 1]->created_at : Carbon::now('Asia/Ho_Chi_Minh');
                        $order_details = Order_detail::with('order.status_orders')
                            ->whereHas('order.status_orders', function ($query) {
                                $query->where('status_id', 3);
                            })
                            ->where('product_variant_id', $variant->id)
                            ->where('created_at', '>=', $currentTime)
                            ->where('created_at', '<', $nextTime)
                            ->get();
                        if ($order_details) {
                            foreach ($order_details as $key => $order_detail) {
                                $totalProfitPerTime += ($order_detail->original_price - $history->import_price) * $order_detail->quantity;
                            }
                        }
                        $totalProfitPerItem += $totalProfitPerTime;
                    }
                }
                $totalProfit += $totalProfitPerItem;
            }
            if ($productDetail) {
                return view('admin.products.show', compact('productDetail', 'productVariants', 'totalProfit', 'productStar', 'variantVoted'));
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Không tìm thấy sản phẩm cần xem chi tiết!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Sản phẩm chi tiết này không có biến thể, đây là sản phẩm lỗi!');
        }
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
    public function getAllCategories()
    {
        $all_categories = Category::where('is_active', 1)->get();
        $categories_tree = $this->buildCategoryTree($all_categories);
        $response = [
            'status' => 200,
            'message' => 'Get data successfully!',
            'data' => $categories_tree
        ];
        return response()->json($response);
    }
    public function createNewCategory()
    {
        $category_name = request()->input('category_name');
        $parent_category_id = request()->input('parent_category_id');

        try {
            if ($parent_category_id) {
                Category::create([
                    'name' => $category_name,
                    'parent_category_id' => $parent_category_id
                ]);
            } else {
                Category::create([
                    'name' => $category_name
                ]);
            }

            $response = [
                'status' => 200,
                'message' => 'Add new category successfully!',
            ];
        } catch (Exception $e) {
            // Xử lý khi có lỗi
            $response = [
                'status' => 400,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ];
        }

        // Trả về JSON response
        return response()->json($response);
    }
    public function checkCategoryById()
    {
        $category_id = request()->input('category_id');
        if ($category_id) {
            $result = Category::find($category_id);
            if ($result) {
                $response = [
                    'status' => 200,
                    'message' => 'This category is not exists!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Something went wrong!',
                ];
            }
            return response()->json($response);
        }
    }
    public function getAllBrands()
    {
        $all_brands = Brand::where('is_active', 1)->get();
        if ($all_brands) {
            $form = [];
            foreach ($all_brands as $brand) {
                $item = [];
                $item['id'] = $brand->id;
                $item['name'] = $brand->name;
                $form[] = $item;
            }
            $response = [
                'status' => 200,
                'message' => 'Get data successfully!',
                'data' => $form
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'Unable get data!'
            ];
        }
        return response()->json($response);
    }
    public function createNewBrand()
    {
        $brand_name = request()->input('brand_name');
        $response = '';
        if ($brand_name) {
            $check_brand_name = Brand::where('name', $brand_name)->first();
            if ($check_brand_name) {
                $response = [
                    'status' => 409,
                    'message' => 'Brand name is already existing!'
                ];
                return response()->json($response);
            }
            $newBrand = Brand::create([
                'name' => $brand_name
            ]);
            if ($newBrand) {
                $response = [
                    'status' => 200,
                    'message' => 'Create new brand successfully!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Unable create new brand!'
                ];
            }
        }
        return response()->json($response);
    }
    public function checkBrandById()
    {
        $brand_id = request()->input('brand_id');
        if ($brand_id) {
            $result = Brand::find($brand_id);
            if ($result) {
                $response = [
                    'status' => 200,
                    'message' => 'This brand is not exists!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Something went wrong!',
                ];
            }
            return response()->json($response);
        }
    }
    public function getSkuProduct()
    {
        $sku = request()->input('sku');
        $checkSku = Product::where('SKU', $sku)->first();
        if ($checkSku) {
            $response = [
                'status' => 400,
                'message' => 'Sku is already exists',
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Sku is valid!',
            ];
        }
        return response()->json($response);
    }
    public function getSkuProductVariation()
    {
        $sku = request()->input('sku');
        $checkSku = Product_variant::where('SKU', $sku)->first();
        if ($checkSku) {
            $response = [
                'status' => 400,
                'message' => 'Sku is already exists',
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Sku is valid!',
            ];
        }
        return response()->json($response);
    }
    private function buildCategoryTree($categories, $parentId = 0)
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_category_id == $parentId) {
                $children = $this->buildCategoryTree($categories, $category->id);
                if ($children) {
                    $category->subcategories = $children;
                } else {
                    $category->subcategories = [];
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }
    public function getAllAttributes()
    {
        $attributes = Attribute::all();
        $attributesJson = [];
        foreach ($attributes as $item) {
            $array = [];
            $array['id'] = $item->id;
            $array['name'] = $item->name;
            $attributesJson[] = $array;
        }
        $response = [
            'status' => 'Successfully',
            'message' => 'Get data successfully!',
            'data' => $attributesJson
        ];
        return response()->json($response);
    }
    public function getAllAttributeValuesById(string $id)
    {
        $attributeValues = Attribute_value::where('attribute_id', $id)->get();
        $attributeValuesJson = [];
        foreach ($attributeValues as $item) {
            $array = [];
            $array['id'] = $item->id;
            $array['value'] = $item->name;
            $attributeValuesJson[] = $array;
        }
        $response = [
            'status' => 'Successfully',
            'message' => 'Get data successfully!',
            'data' => $attributeValuesJson
        ];
        return response()->json($response);
    }
    public function addNewAttributeValueById(string $id)
    {
        $newAttributeValue = request()->input('new_attribute_value');
        $checkAttributeValue = Attribute_value::where('attribute_id', $id)->where('name', $newAttributeValue)->first();
        if ($checkAttributeValue) {
            $response = [
                'status' => 400,
                'message' => 'The attribute value already exists!',
            ];
            return response()->json($response);
        }
        $newAttributeValueModel = new Attribute_value();
        $newAttributeValueModel->attribute_id = $id;
        $newAttributeValueModel->name = $newAttributeValue;
        $newAttributeValueModel->save();
        $array = [];
        $array['id'] = $newAttributeValueModel->id;
        $array['value'] = $newAttributeValueModel->name;
        $response = [
            'status' => 200,
            'message' => 'Add new attribute value successfully!',
            'data' => $array
        ];
        return response()->json($response);
    }
}
