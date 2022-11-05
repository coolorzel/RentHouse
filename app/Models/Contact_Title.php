<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_Title extends Model
{
    use HasFactory;
    protected $table = "contacts_title";

    protected $fillable = [
        'name',
        'description'
    ];

}
