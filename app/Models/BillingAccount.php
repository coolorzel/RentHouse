<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAccount extends Model
{
    use HasFactory;
    protected $table = "billing_accounts";
    protected $fillable = [
        'u_id',
        'company',
        'name',
        'lname',
        'pesel',
        'phone_number',
        'country',
        'province',
        'city',
        'zipcode',
        'street',
        'building_number',
        'company_name',
        'company_nip',
        'company_website',
    ];

    public function messages()
    {
        return $this->hasMany(BillingApplication::class, 'billing_id', 'id');
    }
    public function message()
    {
        return $this->hasOne(BillingApplication::class, 'billing_id', 'id')->latest();
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'u_id');
    }
}
