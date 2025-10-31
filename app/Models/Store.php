<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'vendor_id',
        'store_name',
        'image',
        'address',
        'verification_docs',
        'opening_hours',
        'is_verified',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
