<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'created_at',
        'updated_at'
    ];
    public function banner_images()
    {
        return $this->hasMany(Banner_image::class);
    }
}
