<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant_attribute_value extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
        'created_at',
        'updated_at'
    ];
    public function attribute_value()
    {
        return $this->belongsTo(Attribute_value::class);
    }
    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class);
    }
}
