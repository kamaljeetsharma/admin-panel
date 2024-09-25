<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at'];



    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}


