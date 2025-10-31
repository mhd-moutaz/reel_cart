<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'address',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function favoriteProdusts()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
