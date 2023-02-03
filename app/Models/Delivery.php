<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public const DELIVERY_DATE = 'delivery_date';

    public $table = 'delivery';
    public $timestamps = false;
    public $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }    
}
