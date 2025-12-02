<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'CategoryID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CategoryName',
        'CategoryPrefix',  // optional: store prefix
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CategoryID');
    }

    // Auto-generate CAT001 + Prefix on create
    protected static function booted()
    {
        static::creating(function ($category) {
            // Generate CategoryID: CAT001, CAT002...
            $last = static::orderByRaw('CAST(SUBSTRING(CategoryID, 4) AS UNSIGNED) DESC')->first();
            $nextNum = $last ? (intval(substr($last->CategoryID, 3)) + 1) : 1;
            $category->CategoryID = 'CAT' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            // Auto-generate 3-letter prefix from name
            $prefix = strtoupper(substr($category->CategoryName, 0, 3));
            $category->CategoryPrefix = $prefix;
        });
    }

    // Optional: accessor for count (you already use withCount, but safe)
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}