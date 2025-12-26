<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'vendor_id',
        'title',
        'description',
        'price',
        'quantity',
        'average_rating',
    ];
    public function favoriteClients()
    {
        return $this->belongsToMany(Client::class, 'favorites');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function reels()
    {
        return $this->hasMany(Reel::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
