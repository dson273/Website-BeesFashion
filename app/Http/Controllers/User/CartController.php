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

            $array_item_cart['product_name'] = Product_variant::select('p.name')
                ->rightJoin('products as p', 'product_variants.product_id', '=', 'p.id')
                ->first()->name;

            $array_item_cart['image'] = Product_variant::where('id', $variants->id)->value('image');
            $array_item_cart['regular_price'] = $variants->regular_price;
            $array_item_cart['sale_price'] = $variants->sale_price;
            $array_item_cart['stock'] = $variants->stock;
            $array_item_cart['product_id'] = $variants->product_id;
            $array_item_cart['variant_id'] = $variants->id;
            $array_item_cart['id_cart'] = $itemCart->id;

            // Lấy thông tin thuộc tính và giá trị
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
        // dd($cart_list);
        $total_payment = 0;
        $total_discount = 0;
        foreach ($cart_list as $item_cart) {
            if ($item_cart['sale_price'] != null) {
                $discount = $item_cart['regular_price'] - $item_cart['sale_price'];
                $total_discount += $discount * $item_cart['quantity'];
                $total_payment += $item_cart['sale_price'] * $item_cart['quantity'];
            } else {
                $total_payment += $item_cart['regular_price'] * $item_cart['quantity'];
            }
        }
        return view('user.cart', compact('cart_list', 'total_payment', 'total_discount'));
    }

    // public function getProductVariants($product_id)
    // {
    //     $product = Product::with(['product_variants' => function ($query) {
    //         $query->where('is_active', 1)
    //             ->where('stock', '>', 0);
    //     }, 'product_variants.variant_attribute_values.attribute_value.attribute'])
    //         ->findOrFail($product_id);

    //     // Mảng chứa các biến thể với các attribute_value_id liên quan
    //     $array_variants = $product->product_variants->map(function ($variant) {
    //         return [
    //             'variant_id' => $variant->id,
    //             'image' => $variant->image,
    //             'regular_price' => $variant->regular_price,
    //             'sale_price' => $variant->sale_price,
    //             'stock' => $variant->stock,
    //             'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
    //         ];
    //     })->toArray();

    //     // Lấy tất cả các attribute_value_id và attribute_id duy nhất
    //     $attribute_value_ids = $product->product_variants
    //         ->pluck('variant_attribute_values.*.attribute_value_id')
    //         ->flatten()
    //         ->unique()
    //         ->toArray();

    //     $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
    //         ->pluck('attribute_id')
    //         ->unique()
    //         ->sort()
    //         ->toArray();

    //     // Xây dựng mảng thuộc tính đã lọc
    //     $array_attributes = Attribute::with([
    //         'attribute_values' => function ($query) use ($attribute_value_ids) {
    //             $query->whereIn('id', $attribute_value_ids);
    //         },
    //         'attribute_type' // Lấy thông tin loại thuộc tính
    //     ])->whereIn('id', $attribute_ids)->get()->mapWithKeys(function ($attribute) {
    //         return [
    //             $attribute->id => [
    //                 'id' => $attribute->id,
    //                 'name' => $attribute->name,
    //                 'type' => $attribute->attribute_type ? $attribute->attribute_type->type_name : null, // Lấy tên loại thuộc tính
    //                 'attribute_values' => $attribute->attribute_values->sortBy(function ($value) {
    //                     // Sắp xếp theo thứ tự "S", "M", "L", "XL", nếu giá trị khác số
    //                     $sizes = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
    //                     return $sizes[$value->name] ?? $value->name; // Sắp xếp theo thứ tự định trước hoặc theo tên
    //                 })->values()->map(function ($value) {
    //                     return [
    //                         'id' => $value->id,
    //                         'name' => $value->name,
    //                         'value' => $value->value
    //                     ];
    //                 })->toArray()
    //             ]
    //         ];
    //     })->toArray();

    //     return response()->json([
    //         'success' => true,
    //         'variants' =>  $array_variants,
    //         'attributes' => $array_attributes
    //     ]);
    // }
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
