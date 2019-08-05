<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['user_id', 'registration_no', 'available', 'licence_expiry',
        'rating', 'passport', 'licence', 'car_type'
    ];
}
