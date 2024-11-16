<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'amount',
        'quantity',
        'image',
        'type',
        'start_date',
        'end_date',
        'minimum_order_value',
        'is_active'
    ];
    public function product_vouchers()
    {
        return $this->hasMany(Product_voucher::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_vouchers');
    }
}
