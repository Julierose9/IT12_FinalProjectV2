<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'ProductID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ProductID',
        'ProductName',
        'ProductDescription',
        'CategoryID',
        'SupplierID',
        'SKUNumber',
        'ProductStatus',
        'StockQty',      // Make sure this is included
        'ReorderLevel',  // Make sure this is included
    ];

    public function pricing()
    {
        return $this->hasOne(Pricing::class, 'ProductID', 'ProductID')
                    ->where('IsActive', true)
                    ->latest('EffectiveDate');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'SupplierID');
    }

    // Relationship with StockIn (for stock history)
    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'ProductID', 'ProductID');
    }

    // Calculate current stock from stock-in records
    public function getCurrentStockAttribute()
    {
        return $this->stockIns()->where('ProdStatus', '!=', 'Cancelled')->sum('Qty');
    }

    // Accessor for stock status
    public function getStockStatusAttribute()
    {
        $currentStock = $this->current_stock;
        
        if ($currentStock <= 0) {
            return 'Out of Stock';
        } elseif ($currentStock <= 10) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }
}