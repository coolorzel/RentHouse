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
        'street',
        'building_number',
        'company_name',
        'company_nip',
        'company_website',
    ];
}
