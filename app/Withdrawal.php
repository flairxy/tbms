<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'charge', 'net_amount', 'address', 'gateway', 'transaction_id','hash', 'status', 'user_id'
    ];
}
