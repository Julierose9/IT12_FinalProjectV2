<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'UserID',
        'EmployeeID',
        'email',
        'password',
        'Role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // THIS IS THE MISSING LINE THAT BREAKS EVERYTHING
    protected $casts = [
        'email_verified_at' => 'datetime',
        'Role' => 'string',
    ];

    // CRITICAL: Tell Laravel to use 'email' as login field
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Optional: if you ever use remember token
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
}