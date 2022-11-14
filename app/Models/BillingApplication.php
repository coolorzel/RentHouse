<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingApplication extends Model
{
    use HasFactory;
    protected $table = "billing_application";
    protected $fillable = [
        'billing_id',
        'sender',
        'message',
        'displayed'
    ];
    public function billingAccount()
    {
        return $this->hasOne(BillingAccount::class, 'id', 'billing_id');
    }
}
