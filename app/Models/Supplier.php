<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'SupplierID', 'SupplierName', 'SupplierContactNo', 'Address', 'Status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'SupplierID', 'SupplierID');
    }

    // Auto-set SupplierID before creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            if (empty($supplier->SupplierID)) {
                $lastSupplier = Supplier::orderBy('id', 'desc')->first();
                $newId = $lastSupplier ? intval(substr($lastSupplier->SupplierID, 3)) + 1 : 1;
                $supplier->SupplierID = 'SUP' . str_pad($newId, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}