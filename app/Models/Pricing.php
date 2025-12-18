<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $table = 'pricing';
    protected $primaryKey = 'PricingID';
    public $incrementing = false;
    protected $keyType = 'string';

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
                // Get the highest numeric part of existing PricingIDs
                $highest = Pricing::selectRaw("CAST(SUBSTRING(PricingID, 4) AS UNSIGNED) as num")
                    ->orderByRaw("CAST(SUBSTRING(PricingID, 4) AS UNSIGNED) DESC")
                    ->first();
                
                $nextNumber = 1;
                if ($highest && $highest->num) {
                    $nextNumber = $highest->num + 1;
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