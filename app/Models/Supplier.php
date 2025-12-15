<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'SupplierID';    // This is the key!
    public $incrementing = false;            // Not auto-increment int
    protected $keyType = 'string';           // It's a string

    protected $fillable = [
        'SupplierID',
        'SupplierName',
        'SupplierContactNo',
        'Address',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'SupplierID', 'SupplierID');
    }

    // Auto-generate SUP001, SUP002... in Laravel
    protected static function booted()
    {
        static::creating(function ($supplier) {
            if (empty($supplier->SupplierID)) {
                $last = static::orderByRaw('CAST(SUBSTRING(SupplierID, 4) AS UNSIGNED) DESC')->first();
                $nextNum = $last ? (intval(substr($last->SupplierID, 3)) + 1) : 1;
                $supplier->SupplierID = 'SUP' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Virtual Status attribute so views can still use $supplier->Status
    public function getStatusAttribute($value)
    {
        // If the column doesn't exist, $value will be null; default to 'Active'
        return $value ?? 'Active';
    }
}