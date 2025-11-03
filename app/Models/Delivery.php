<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    protected $fillable = [
        'user_id',
        'national_id',
        'address',
        'birth_date',
    ];
=======

class Delivery extends Model
{
    protected $fillable = ['user_id', 'national_id', 'address', 'birth_date'];

>>>>>>> 9b6bf30a7fd44da3f1c859a437a99ce6920e1621
    public function user()
    {
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD

    public function orders(){
=======
    public function orders()
    {
>>>>>>> 9b6bf30a7fd44da3f1c859a437a99ce6920e1621
        return $this->hasMany(Order::class);
    }
}
