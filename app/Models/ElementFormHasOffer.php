<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementFormHasOffer extends Model
{
    use HasFactory;

    protected $table = 'element_form_has_offers';
    protected $fillable = [
        'offer_id',
        'element_form_names_id'
    ];
}
