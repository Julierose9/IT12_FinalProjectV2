<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $primaryKey = 'PricingID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ProductID',
        'OriginalPrice',
        'RetailPrice',
        'MarkupRate',
        'EffectiveDate',
        'IsActive'
    ];

    protected $casts = [
        'OriginalPrice' => 'decimal:2',
        'RetailPrice' => 'decimal:2',
        'MarkupRate' => 'decimal:2',
        'EffectiveDate' => 'date',
        'IsActive' => 'boolean'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'SKUNumber');
    }
}