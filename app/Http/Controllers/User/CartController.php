<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Attribute_value;
use Illuminate\Http\Request;
use App\Models\Product_variant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_variant_attribute_value;

class CartController extends Controller
{


    public function index()
    {
        $carts = Auth::user()->carts;
        $cart_list = [];
        foreach ($carts as $itemCart) {
            $array_item_cart = [];
            $array_item_cart['quantity'] = $itemCart->quantity;
            $variants = $itemCart->product_variant;
            $product_variant_id = $itemCart['product_variant_id'];
            $array_item_cart['product_name'] = Product_variant::with('product')
                ->where('id', $product_variant_id)
                ->first()?->product?->name ?? 'Tên sản phẩm không tồn tại';
            $array_item_cart['image'] = Product_variant::where('id', $variants->id)->value('image');
            $array_item_cart['regular_price'] = $variants->regular_price;
            $array_item_cart['sale_price'] = $variants->sale_price;
            $array_item_cart['stock'] = $variants->stock;
            $array_item_cart['sku'] = $variants->product->SKU;
            $array_item_cart['product_id'] = $variants->product_id;
            $array_item_cart['variant_id'] = $variants->id;
            $array_item_cart['id_cart'] = $itemCart->id;

            $array_item_attribute_values = [];
            $productAttributeValueDetails = Product_variant_attribute_value::where('product_variant_id', $variants->id)->get();

            foreach ($productAttributeValueDetails as $itemProductAttributeValueDetail) {
                $attributeValue = $itemProductAttributeValueDetail->attribute_value;
                $attribute = $attributeValue->attribute;
                $array_item_attribute_values[] = [
                    'attribute_name' => $attribute->name,
                    'value_name' => $attributeValue->name,
                    'value_code' => $attributeValue->value
                ];
            }
            $array_item_cart['attribute_values'] = $array_item_attribute_values;
            $cart_list[] = $array_item_cart;
        }

        //tổng giá trong giỏ hàng
        $total_payment = 0;
        $total_discount = 0;
        foreach ($cart_list as $item_cart) {
            if ($item_cart['sale_price'] != null) {
                $discount = $item_cart['regular_price'] - $item_cart['sale_price'];
                $total_discount += $discount * $item_cart['quantity'];
                $total_payment += $item_cart['regular_price'] * $item_cart['quantity'];
            } else {
                $total_payment += $item_cart['regular_price'] * $item_cart['quantity'];
            }
        }

        //  dd($cart_list);
        return view('user.cart', compact('cart_list', 'total_payment', 'total_discount'));
    }

    public function removeFromCart($id)
    {
        // Xóa sản phẩm khỏi giỏ hàng
        $user = Auth::user();
        $cartItemID = $user->carts()->find($id); // Tìm sản phẩm trong giỏ hàng theo ID

        if ($cartItemID) {
            // Nếu tìm thấy sản phẩm, xóa sản phẩm đó
            $cartItemID->delete();
        }

        // Sau khi xóa sản phẩm, tính lại giỏ hàng
        return redirect()->route('cart')->with('statusSuccess', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
    public function clearAll()
    {
        // Xóa tất cả sản phẩm trong giỏ hàng của người dùng
        Auth::user()->carts()->delete(); // Hoặc tùy vào cách bạn lưu giỏ hàng, nếu có mối quan hệ khác
        return redirect()->route('cart')->with('statusSuccess', 'Giỏ hàng đã được làm sạch.');
    }

    public function getProductVariants($product_id)
    {
        // Lấy sản phẩm với các biến thể và các giá trị thuộc tính liên quan
        $product = Product::with([
            'product_variants' => function ($query) {
                // Lọc các biến thể có sẵn và còn hàng
                $query->where('is_active', 1)->where('stock', '>', 0);
            },
            'product_variants.variant_attribute_values.attribute_value',
            'product_variants.product' // Nạp thông tin sản phẩm liên quan
        ])
        ->findOrFail($product_id); // Tìm sản phẩm theo ID hoặc trả lỗi 404 nếu không tìm thấy
    
        // Tạo danh sách các biến thể của sản phẩm
        $array_variants = $product->product_variants->map(function ($variant) {
            return [
                'product_variant_id' => $variant->id,
                'name' => $variant->name, // Tên biến thể
                'stock' => $variant->stock,
                'product_id' => $variant->product_id, // ID sản phẩm
                'attributes' => $variant->variant_attribute_values->map(function ($value) {
                    return [
                        'attribute_id' => $value->attribute_value->attribute_id,
                        'attribute_name' => $value->attribute_value->attribute->name, // Tên thuộc tính
                        'value_id' => $value->attribute_value->id,
                        'value_name' => $value->attribute_value->name, // Tên giá trị thuộc tính
                        'value' => $value->attribute_value->value, // Giá trị thuộc tính
                    ];
                })->toArray() // Thêm mảng thuộc tính cho mỗi biến thể
            ];
        })->toArray();
    
        // Lấy các ID của giá trị thuộc tính từ các biến thể
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
        ])
        ->whereIn('id', $attribute_ids)
        ->get()
        ->mapWithKeys(function ($attribute) {
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
    
        // Trả về dữ liệu dưới dạng JSON cho frontend
        return response()->json([
            'success' => true,
            'variants' => $array_variants, // Danh sách các biến thể sản phẩm
            'attribute_data' => $array_attributes, // Dữ liệu thuộc tính của các biến thể
        ]);
    }
    
    
    

    





//     "variants": [
//         {
//             "product_variant_id": 5,
//             "name": "red-XL",
//             "product_id": 2
//         },
//         {
//             "product_variant_id": 6,
//             "name": "red-XXL",
//             "product_id": 2
//         }
// ],
        
//             "attribute_data": [
//                 {
//                     "attribute_id": 1,
//                     "attribute_name": "Màu sắc\r\n",
//                     "attribute_type": "color",
//                     "attribute_values": [
//                         {
//                             "attribute_value_id": 1,
//                             "attribute_value_name": "red"
//                         },
//                         {
//                             "attribute_value_id": 4,
//                             "attribute_value_name": "blue"
//                         }
//                     ]
//                 },
//                 {
//                     "attribute_id": 2,
//                     "attribute_name": "Kích cỡ",
//                     "attribute_type": "Button",
//                     "attribute_values": [
//                         {
//                             "attribute_value_id": 2,
//                             "attribute_value_name": "XL"
//                         },
//                         {
//                             "attribute_value_id": 3,
//                             "attribute_value_name": "XXL"
//                         }
//                     ]
//                 }
//             ]
        
       





    public function updateQuantity(Request $request)
    {
        $cart_id = request()->input('cart_id');
        $new_quantity = request()->input('new_quantity');
        $product_variant_id = request()->input('product_variant_id');
        $change_type = request()->input('change_type');

        $check_cart = Cart::find($cart_id);
        $response = [];
        if ($check_cart) {
            $check_product_variant = Product_variant::find($product_variant_id);
            if ($check_product_variant) {
                if ($change_type == "plus") {
                    if ($new_quantity <= $check_product_variant->stock) {
                        $check_cart->quantity = $new_quantity;
                        $check_cart->save();
                        $response = [
                            'status' => 200,
                            // 'message' => 'Đã đạt đến số lượng tối đa!',
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'message' => 'Đã đạt đến số lượng tối đa!',
                        ];
                    }
                } else {
                    if ($new_quantity >= 1) {
                        $check_cart->quantity = $new_quantity;
                        $check_cart->save();
                        $response = [
                            'status' => 200,
                            // 'message' => 'Đã đạt đến số lượng tối đa!',
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'message' => 'Đã đạt đến số lượng tối thiểu!',
                        ];
                    }
                }
            } else {
                $response = [
                    'status' => 401,
                    'message' => 'Không tìm thấy biến thể cần cập nhật số lượng!',
                ];
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'Không tìm thấy giỏ hàng cần cập nhật số lượng!',
            ];
        }
        return response()->json($response);
    }

    public function updateVariant(Request $request)
    {


        $cart = Cart::findOrFail($request->cart_id);
        $newVariant = Product_variant::findOrFail($request->variant_id);

        // Kiểm tra stock của variant mới
        if ($cart->quantity > $newVariant->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho của biến thể mới'
            ], 422);
        }

        $cart->product_variant_id = $newVariant->id;
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật biến thể thành công',
            'new_price' => $newVariant->sale_price ?? $newVariant->regular_price,
            'new_total' => ($newVariant->sale_price ?? $newVariant->regular_price) * $cart->quantity,
            'stock' => $newVariant->stock
        ]);
    }
}
