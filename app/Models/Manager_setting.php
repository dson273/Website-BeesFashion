<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'manager_name',
        'created_at',
        'updated_at'
    ];
    public function user_manager_settings()
    {
        return $this->hasMany(User_manager_setting::class);
    }
}
