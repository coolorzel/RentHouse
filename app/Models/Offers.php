<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = [
        'isCreated',
        'isActive',
        'isDeactive',
        'isAcceptMod',
        'cat_id',
        'u_id',
        'billing_id',
        'images_id',
        'payment',
        'name',
        'slug',
        'description',
        'rooms',
        'surface',
        'land_area',
        'regular_rent',
        'sale_rent',
        'deposit',
        'contact_tel',
        'contact_email',
        'featured',
        'archivum',
        'older',
        'lat',
        'lon',
        'state',
        'city',
        'postcode',
        'additional_information',
    ];

    public function activeElement (){
        return $this->hasMany(ElementFormHasOffer::class, 'offer_id', 'id');
    }

    public function images (){
        return $this->hasMany(OfferImages::class, 'o_id', 'id');
    }

    public function category (){
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }

    public function user () {
        return $this->hasOne(User::class, 'id', 'u_id');
    }

    public function billingAccount (){
        return $this->hasOne(BillingAccount::class, 'id', 'billing_id');
    }
}
