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
    public function formInCategory()
    {
        return $this->hasMany(ElementFormInCategory::class, 'cat_id', 'id')->pluck('form_id')->toArray();
    }

    public function forms()
    {
        return $this->belongsToMany(ElementFormOffer::class, 'element_form_in_categories', 'cat_id', 'form_id');
    }

}
