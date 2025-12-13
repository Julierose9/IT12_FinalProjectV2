<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrderDetailID';
    protected $table = 'order_details';
    
    protected $fillable = [
        'OrderDetailID',
        'OrderID',
        'ProductID',
        'OrderQty',
        'UnitPrice',
        'Subtotal',
        'Size',
        'Color'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}