<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';
    protected $primaryKey = 'InventoryID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'InventoryID',
        'ProductID',
        'QtyChange',
        'ChangeType',
        'ChangeDateTime',
        'reference_type',
        'reference_id',
        'notes'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}