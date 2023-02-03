<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'client';
    public $timestamps = false;
    public $guarded = [];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }    

    public function orders()
    {
        return $this->hasMany(Order::class);
    }    
}
