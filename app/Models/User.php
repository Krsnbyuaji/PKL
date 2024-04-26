<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // Perbaikan pada penggunaan trait
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject; // Perbaikan pada namespace

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable; // Perbaikan pada penggunaan trait

    protected $table = 'users';
   
    protected $fillable = [
         'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
