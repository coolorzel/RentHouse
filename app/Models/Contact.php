<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = "contacts";
    protected $fillable = [
        'message',
        'email',
        'name',
        'lname',
        'u_id',
        'title_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'u_id');
    }
    public function title()
    {
        return $this->hasOne(Contact_Title::class, 'id', 'title_id');
    }
}
