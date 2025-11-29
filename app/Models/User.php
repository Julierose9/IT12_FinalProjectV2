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
    public $incrementing = false;          // Because UserID = USR001
    protected $keyType = 'string';         // string PK

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

    // Laravel automatically uses "email" for login
    // Laravel automatically uses "password" for authentication
}
