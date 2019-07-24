<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'amount', 'user_id', 'gateway', 'end', 'last_profit', 'start', 'reference_id', 'plan', 'plan_id', 'charge'
    ];
}
