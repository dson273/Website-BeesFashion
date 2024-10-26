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
        'fixed',
        'is_active',
        'parent_category_id',
        'created_at',
        'updated_at'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
    public function product_categories()
    {
        return $this->hasMany(Product_category::class);
    }
   
    public static function recursive($cate_parent, $parents = 0, $level = 1, &$listCate)
    {
        if (count($cate_parent) > 0) {
            foreach ($cate_parent as $key => $value) {
                if ($value->parent_category_id == $parents) {
                    $value->level = $level;
                    $listCate[] = $value;
                    unset($cate_parent[$key]);

                    $parent = $value->id;
                    self::recursive($cate_parent, $parent, $level + 1, $listCate);
                }
            }
        }
    }
}
