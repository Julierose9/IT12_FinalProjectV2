<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'OrderID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'OrderID',
        'EmployeeID',
        'CustomerName',
        'CustomerContact',
        'OrderDateTime',
        'OrderStatus',
        'SubTotal',
        'DiscountType',
        'DiscountRate',
        'DiscountAmount',
        'GrandTotal',
        'PaymentMethod',
        'PaymentStatus',
        'PaymentReference',
        'AmountPaid',
        'Balance'
    ];
    
    protected $casts = [
        'OrderDateTime' => 'datetime',
        'SubTotal' => 'decimal:2',
        'DiscountRate' => 'decimal:2',
        'DiscountAmount' => 'decimal:2',
        'GrandTotal' => 'decimal:2',
        'AmountPaid' => 'decimal:2',
        'Balance' => 'decimal:2'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'OrderID', 'OrderID');
    }
    
    // Relationship with order items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'OrderID', 'OrderID');
    }
    
    // Relationship with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
    
    // Helper method to get items count
    public function getItemsCountAttribute()
    {
        return $this->items()->sum('Quantity');
    }
}