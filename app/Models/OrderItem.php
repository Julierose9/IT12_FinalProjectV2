<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'OrderDetailsID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'order_details';

    protected $fillable = [
        'OrderDetailsID',
        'OrderID',
        'ProductID',
        'OrderQty',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    /**
     * Provide a Quantity attribute to mirror expected naming in views/controllers.
     */
    public function getQuantityAttribute()
    {
        return $this->OrderQty;
    }

    /**
     * Price is not stored on the detail; pull from linked product pricing when available.
     */
    public function getPriceAttribute()
    {
        return $this->product->pricing->RetailPrice ?? 0;
    }
}

