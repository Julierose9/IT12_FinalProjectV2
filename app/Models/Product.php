<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'SKUNumber';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'SKUNumber',
        'ProductName',
        'ProductDescription',
        'ReorderLevel',
        'ProductStatus',
        'SupplierID',
        'CategoryID'
    ];

    protected $casts = [
        'ReorderLevel' => 'integer'
    ];

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

    // Relationship with Pricing
    public function pricing()
    {
        return $this->hasOne(Pricing::class, 'ProductID', 'SKUNumber')->where('IsActive', true);
    }

    // Accessor for current price
    public function getCurrentPriceAttribute()
    {
        return $this->pricing ? $this->pricing->RetailPrice : 0;
    }

    // Accessor for cost price
    public function getCostPriceAttribute()
    {
        return $this->pricing ? $this->pricing->OriginalPrice : 0;
    }

    // Accessor for stock status
    public function getStockStatusAttribute()
    {
        // You might need to calculate current stock from inventory transactions
        $currentStock = $this->calculateCurrentStock();
        
        if ($currentStock <= 0) {
            return 'Out of Stock';
        } elseif ($currentStock <= $this->ReorderLevel) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    // Calculate current stock (you'll need to implement this based on your inventory system)
    private function calculateCurrentStock()
    {
        // This is a placeholder - implement based on your stock_in, stock_out tables
        return 0; // Default value
    }

    // Accessor for profit margin
    public function getProfitMarginAttribute()
    {
        $cost = $this->cost_price;
        $retail = $this->current_price;
        
        if ($cost > 0 && $retail > 0) {
            return (($retail - $cost) / $cost) * 100;
        }
        return 0;
    }
}