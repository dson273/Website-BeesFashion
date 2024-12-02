<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'SKU',
        'name',
        'view',
        'description',
        'fake_sales',
        'is_active',
        'brand_id'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'product_vouchers');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function product_variants()
    {
        return $this->hasMany(Product_variant::class);
    }
    public function product_categories()
    {
        return $this->hasMany(Product_category::class);
    }
    public function product_files()
    {
        return $this->hasMany(Product_file::class);
    }
    public function product_gallery()
    {
        return $this->hasMany(Product_file::class)->where('is_default', 0)->where('file_type', 'image');
    }

    public function product_videos()
    {
        return $this->hasMany(Product_file::class)->where('is_default', 0)->where('file_type', 'video');
    }
    public function product_likes()
    {
        return $this->hasMany(Product_like::class);
    }
    public function product_vouchers()
    {
        return $this->hasMany(Product_voucher::class);
    }
    public function favorite_products()
    {
        return $this->hasMany(Favorite_product::class);
    }
    public function product_view_histories()
    {
        return $this->hasMany(Product_view_history::class);
    }
    public function getPriceRangeAttribute()
    {
        $salePrices = $this->product_variants->pluck('sale_price')->filter();
        $importPrices = $this->product_variants->pluck('regular_price')->filter();
    
        $minSalePrice = $salePrices->min();
        $maxSalePrice = $salePrices->max();
        $minImportPrice = $importPrices->min();
        $maxImportPrice = $importPrices->max();
    
        // Nếu không có giá khuyến mãi
        if ($salePrices->isEmpty()) {
            return number_format($minImportPrice) . " ₫ - " . number_format($maxImportPrice) . " ₫";
        }
    
        // Nếu có giá khuyến mãi, xử lý các trường hợp
        if ($minSalePrice === $maxSalePrice) {
            return number_format($minSalePrice) . " ₫";
        }
    
        return number_format($minSalePrice) . " ₫ - " . number_format($maxSalePrice) . " ₫";
    }
    
}
