<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'voucher_id',
        'created_at',
        'updated_at'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
