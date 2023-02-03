<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const PERIOD_FROM = 'period_from';

    public $table = 'order';
    public $timestamps = false;
    public $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }    
}
