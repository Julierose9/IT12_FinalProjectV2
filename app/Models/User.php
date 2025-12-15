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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    // For Laravel's default authentication
    public function getAuthIdentifierName()
    {
        return 'UserID';
    }

    public function getAuthIdentifier()
    {
        return $this->UserID;
    }
}