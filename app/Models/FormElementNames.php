<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormElementNames extends Model
{
    use HasFactory;
    protected $table = 'form_element_names';
    protected $fillable = [
        'name',
        'e_id'
    ];

    public function element()
    {
        return $this->hasOne(ElementFormOffer::class, 'id', 'e_id');
    }
}
