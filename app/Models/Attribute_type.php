<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_type extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_name'
    ];
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
