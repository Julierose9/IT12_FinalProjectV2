<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'stock_in';
    protected $primaryKey = 'StockInID';
    public $timestamps = true;
    
    protected $fillable = [
        'ProductID',
        'SupplierID',
        'Qty',
        'ProdStatus',
        'DateRcvd',
        
    ];
    
    protected $dates = ['DateRevd'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'SupplierID');
    }
}