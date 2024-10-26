<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Models\Category;
use App\Models\Import_history;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_file;
use App\Models\Product_variant;
use App\Models\Product_variant_attribute_value;
use Exception;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return redirect()->route('admin.products.index')->with('statusSuccess','Website loaded successfully!');
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
            if ($sku && $name && $description) {
                $newProduct = Product::create([
                    'SKU' => $sku,
                    'name' => $name,
                    'description' => $description,
                    'is_active' => $status
                ]);
                if ($request->hasFile('mainImage')) {
                    $mainImage = $request->file('mainImage');
                    $mainImagePath = $mainImage->store('upload/products/images');

                    if ($mainImagePath) {
                        Product_file::create([
                            'file_name' => basename($mainImagePath),
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
                        $imagePath = $image->store('upload/products/images');
                        $imagesPaths[] = basename($imagePath);
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
                        $videoPath = $video->store('upload/products/videos');
                        $videosPaths[] = basename($videoPath);
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
                    $importPriceVariation = $request->input("variations.$index.import_price");
                    $salePriceVariation = $request->input("variations.$index.sale_price");
                    $stockVariation = $request->input("variations.$index.stock");
                    $activeVariation = $request->input("variations.$index.active") ? 1 : 0;

                    // Kiểm tra và lưu ảnh biến thể nếu tồn tại
                    $imageVariationPath = null;
                    if ($request->hasFile("variations.$index.image_data")) {
                        $imageVariation = $request->file("variations.$index.image_data");
                        $imageVariationPath = $imageVariation->store('upload/products/images');
                    }

                    // Tạo mới Product_variant
                    $newProductVariation = Product_variant::create([
                        'SKU' => $skuVariation,
                        'name' => $nameVariation,
                        'image' => $imageVariationPath ? basename($imageVariationPath) : null,
                        'sale_price' => $salePriceVariation,
                        'stock' => $stockVariation,
                        'product_id' => $newProduct->id,
                        'is_active' => $activeVariation
                    ]);

                    // Thêm vào bảng Import_history
                    Import_history::create([
                        'quantity' => $stockVariation,
                        'import_price' => $importPriceVariation,
                        'product_variant_id' => $newProductVariation->id
                    ]);

                    // Xử lý dữ liệu variationAttributeData
                    $variationAttributeData = $request->input("variations.$index.variationAttributeData");
                    foreach ($variationAttributeData as $attributeItem) {
                        if (!empty($attributeItem['attributeId'])) {
                            if (!empty($attributeItem['attributeValueId'])) {
                                Product_variant_attribute_value::create([
                                    'product_variant_id' => $newProductVariation->id,
                                    'attribute_value_id' => $attributeItem['attributeValueId']
                                ]);
                            }
                        } else {
                            if ($attributeItem['attributeValue'] && $attributeItem['attributeValue'] != '') {
                                $checkAttribute = false;
                                foreach ($attributeData as $itemAttributeData) {
                                    if ($itemAttributeData['attributeName'] == $attributeItem['attributeName']) {
                                        $findAttributeValue = Attribute_value::where('value', $attributeItem['attributeValue'])
                                            ->where('attribute_id', $itemAttributeData['attributeId'])->first();

                                        if ($findAttributeValue) {
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $findAttributeValue->id
                                            ]);
                                        } else {
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
                                    $newAttribute = Attribute::create(['name' => $attributeItem['attributeName']]);
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
    public function getAllCategories()
    {
        $all_categories = Category::where('is_active', 1)->get();
        $categories_tree = $this->buildCategoryTree($all_categories);
        $response = [
            'status' => 'Successfully',
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
