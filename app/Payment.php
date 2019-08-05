<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'rider_id',
        'driver_id',
        'ride_id',
        'status',
        'amount',
        'payment',
    ];
}
