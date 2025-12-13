<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;
    
    protected $table = 'stock_in';
    protected $primaryKey = 'StockInID';
    public $incrementing = false; 
    protected $keyType = 'string';
    
    protected $fillable = [
        'ProductID',
        'SupplierID',
        'Qty',
        'ProdStatus',
        'DateRcvd',
        'ExpirationDate'
    ];
    
    protected $dates = ['DateRcvd', 'ExpirationDate'];
    
    // auto-generate StockInID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->StockInID)) {
                $latest = StockIn::latest('StockInID')->first();
                $nextNumber = 1;
                
                if ($latest) {
                    $lastNumber = (int) substr($latest->StockInID, 5); 
                    $nextNumber = $lastNumber + 1;
                }
                
                $model->StockInID = 'STKIN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'SupplierID');
    }
    public function pullOuts()
    {
        return $this->hasMany(PullOut::class, 'StockInID', 'StockInID');
    }
}