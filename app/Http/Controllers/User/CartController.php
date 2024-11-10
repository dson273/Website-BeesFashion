<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_variant;
use App\Models\Product_variant_attribute_value;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
