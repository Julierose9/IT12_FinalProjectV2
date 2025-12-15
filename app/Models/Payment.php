<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'PaymentID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'payments';

    protected $fillable = [
        'PaymentID',
        'OrderID',
        'PaymentType',
        'ReferenceNumber',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }

    // Accessors to provide expected fields in views
    public function getAmountAttribute()
    {
        return $this->order->GrandTotal ?? 0;
    }

    public function getPaymentDateAttribute()
    {
        return $this->created_at;
    }

    public function getPaymentStatusAttribute()
    {
        return 'Paid';
    }
}
