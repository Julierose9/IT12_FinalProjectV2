<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PullOut extends Model
{
    use HasFactory;
    
    protected $table = 'pull_out';
    protected $primaryKey = 'PullOutID';
    public $incrementing = false; // Add this line - IMPORTANT!
    protected $keyType = 'string'; // Add this line - IMPORTANT!
    public $timestamps = true;
    
    protected $fillable = [
        'PullOutID', // Add this to fillable
        'EmployeeID',
        'ProductID',
        'PullOutQty',
        'PullOutReason',
        'PullOutType',
        'DatePullOut'
    ];
    
    /**
     * Get the product associated with the pullout
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
    
    /**
     * Get the employee associated with the pullout
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
}   