<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementFormOffer extends Model
{
    use HasFactory;

    protected $table = "element_form";
    protected $fillable = [
        'name',
        'type',
        'title',
        'have_options'
    ];


    public function formInCategory()
    {
        return $this->hasMany(ElementFormInCategory::class, 'form_id', 'id');
    }

    public function options()
    {
        return $this->hasOne(FormElementNames::class, 'e_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(FormElementNames::class, 'e_id', 'id');
    }
}
