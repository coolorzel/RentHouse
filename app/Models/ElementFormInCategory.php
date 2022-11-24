<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ElementFormInCategory extends Model
{
    use HasFactory;
    protected $table = "element_form_in_categories";
    protected $fillable = [
        'cat_id',
        'form_id'
    ];
    public function forms()
    {
        return $this->hasMany(FormElementNames::class, 'id', 'form_id');
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'cat_id');
    }
}
