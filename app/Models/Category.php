<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'description',
        'is_active',
        'created_at',
        'updated_at'
    ];
    public function product_categories()
    {
        return $this->hasMany(Product_category::class);
    }
}
