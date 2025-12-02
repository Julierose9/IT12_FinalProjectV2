<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Laravel defaults to this
    public $incrementing = true;
    protected $keyType = 'int';

    // This column will store EMP001, EMP002, etc.
    protected $fillable = [
        'EmployeeID', // now safe to mass assign
        'EmployeeFName',
        'EmployeeLName',
        'EmployeeMName',
        'EmployeeContactNum',
        'Role',
        'EmployeeStatus'
    ];

    // Auto-generate EmployeeID like EMP001 when creating
    protected static function booted()
    {
        static::creating(function ($employee) {
            $latest = static::max('id');
            $nextId = $latest ? $latest + 1 : 1;
            $employee->EmployeeID = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        });
    }
}