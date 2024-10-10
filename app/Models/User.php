<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function product_likes()
    {
        return $this->hasMany(Product_like::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function user_shipping_addresses()
    {
        return $this->hasMany(User_shipping_address::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function product_votes()
    {
        return $this->hasMany(Product_vote::class);
    }
    public function favorite_products()
    {
        return $this->hasMany(Favorite_product::class);
    }
    public function product_view_histories()
    {
        return $this->hasMany(Product_view_history::class);
    }
    public function user_manager_settings()
    {
        return $this->hasMany(User_manager_setting::class);
    }
    public function user_bans(){
        return $this->hasMany(User_ban::class);
    }
}
