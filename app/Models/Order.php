<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_cost',
        'shipping_price',
        'shipping_voucher',
        'voucher',
        'total_payment',
        'user_id',
        'user_shipping_address_id',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function user_shipping_address()
    {
        return $this->belongsTo(User_shipping_address::class);
    }
    public function status_orders()
    {
        return $this->hasMany(Status_order::class);
    }
}
