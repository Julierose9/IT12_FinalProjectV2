<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PullOut extends Model
{
    protected $table = 'pull_out';
    protected $primaryKey = 'PullOutID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'PullOutID',
        'EmployeeID',
        'ProductID',
        'PullOutQty',
        'PullOutReason',
        'PullOutType',
        'DatePullOut'
    ];
    
    
   
    protected $dates = ['DatePullOut'];
    
    /**
     * Get the employee associated with the pullout.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
    
    /**
     * Get the product associated with the pullout.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}