<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
        'name',
        'slug',
        'description',
        'enable',
        'icon'
        ];

    public function getRouteKeyName()
    {
        return strtolower('slug');
    }
}
