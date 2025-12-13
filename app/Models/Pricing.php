<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $table = 'pricing';
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

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->PricingID)) {
                $latest = Pricing::latest('PricingID')->first();
                $nextNumber = 1;
                
                if ($latest) {
                    // Extract number from existing PricingID (e.g., PRC001 -> 1)
                    $lastNumber = (int) substr($latest->PricingID, 3); // Skip 'PRC'
                    $nextNumber = $lastNumber + 1;
                }
                
                $model->PricingID = 'PRC' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // FIXED Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

}