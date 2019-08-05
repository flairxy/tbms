<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'rider_id',
        'driver_id',
        'location',
        'destination',
        'rating',
        'time',
        'date',
        'status'
    ];
}
