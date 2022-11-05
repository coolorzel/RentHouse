<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_Control extends Model
{
    use HasFactory;

    protected $table = "contacts_control";
    protected $fillable = [
        'information',
        'message',
        'message_id',
        'viewer_u_id'
    ];

    public function message()
    {
        return $this->hasOne(Contact::class, 'id', 'message_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'viewer_u_id');
    }
}
