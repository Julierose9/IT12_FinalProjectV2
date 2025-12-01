<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'CategoryID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CategoryID',
        'CategoryName'
    ];

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CategoryID');
    }

    // Accessor for products count
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}