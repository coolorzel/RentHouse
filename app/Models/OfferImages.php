<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferImages extends Model
{
    use HasFactory;

    protected $table = "offer_images";
    protected $fillable = [
        'name',
        'alt',
        'o_id',
    ];
}
