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
        'tax',
        'total_payment',
        'full_name',
        'phone_number',
        'address',
        'payment_method',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }
    public function status_orders()
    {
        return $this->hasMany(Status_order::class);
    }
}
