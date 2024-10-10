<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner_image extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'banner_id',
        'created_at',
        'updated_at'
    ];
    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
