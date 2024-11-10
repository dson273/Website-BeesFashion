<?php

namespace App\Http\Controllers\admin;

use App\Models\Product_variant;
use Illuminate\Http\Request;
use App\Models\Import_history;
use App\Http\Controllers\Controller;

class ImportHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $importHistories = Import_history::get();
        return view('admin.import_history.index', compact('importHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateQuantity(Request $request)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ], [ 
        'quantity.required' => 'Số lượng là bắt buộc.',
        'quantity.integer' => 'Số lượng phải là một số nguyên.',
        'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
    ]);

    $skuId = $request->SKU;
    $quantityToAdd = $request->quantity;
    $productVariant = Product_variant::find($skuId);

    if ($productVariant) {
        // Tìm ImportHistory hiện tại để cập nhật
        $importHistory = Import_history::where('product_variant_id', $skuId)->latest()->first();

        if ($importHistory) {
            $productVariant->stock += $quantityToAdd;
            $productVariant->save();

            $importHistory->quantity += $quantityToAdd;
            $importHistory->save();

            return redirect()->route('admin.import_history.index')
                ->with('statusSuccess', 'Cập nhật số lượng thành công!');
        }
    }

}


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
