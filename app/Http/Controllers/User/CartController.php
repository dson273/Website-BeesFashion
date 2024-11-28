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
        $product = Product::with(['product_variants' => function ($query) {
            $query->where('is_active', 1)
                ->where('stock', '>', 0);
        }, 'product_variants.variant_attribute_values.attribute_value.attribute'])
            ->findOrFail($product_id);

        // Mảng chứa các biến thể với các attribute_value_id liên quan
        $array_variants = $product->product_variants->map(function ($variant) {
            return [
                'variant_id' => $variant->id,
                'image' => $variant->image,
                'regular_price' => $variant->regular_price,
                'sale_price' => $variant->sale_price,
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

        return response()->json([
            'success' => true,
            'variants' =>  $array_variants,
            'attributes' => $array_attributes
        ]);
    }

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

    // public function updateVariant(Request $request)
    // {
    //     $request->validate([
    //         'cart_id' => 'required|exists:carts,id',
    //         'variant_id' => 'required|exists:product_variants,id'
    //     ]);

    //     $cart = Cart::findOrFail($request->cart_id);
    //     $newVariant = Product_variant::findOrFail($request->variant_id);

    //     // Kiểm tra stock của variant mới
    //     if ($cart->quantity > $newVariant->stock) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Số lượng vượt quá tồn kho của biến thể mới'
    //         ], 422);
    //     }

    //     $cart->product_variant_id = $newVariant->id;
    //     $cart->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Cập nhật biến thể thành công',
    //         'new_price' => $newVariant->sale_price ?? $newVariant->regular_price,
    //         'new_total' => ($newVariant->sale_price ?? $newVariant->regular_price) * $cart->quantity,
    //         'stock' => $newVariant->stock
    //     ]);
    // }
}
