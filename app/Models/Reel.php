<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    protected $fillable = [
        'product_id',
        'reel_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
