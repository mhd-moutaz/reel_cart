<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'national_id',
        'business_type',
        'description',
        'verification_status',
        'has_store',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function store()
    {
        return $this->hasOne(Store::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
