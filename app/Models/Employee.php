<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'EmployeeID';
    
    protected $fillable = [
        'EmployeeFName',
        'EmployeeLName', 
        'EmployeeMName',
        'EmployeeContactNum',
        'EmployeeEmail',
        'Role',
        'EmployeeStatus'
    ];
    
    public $timestamps = true;
    
    
}