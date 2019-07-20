<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'amount2',
        'charge',
        'net_amount',
        'status',
        'details',
        'currency1',
        'currency2',
        'gateway_id',
        'payment',
        'created_at'
    ];

    public function user(){

        return $this->belongsTo(User::class);

    }
    public function gateway(){

        return $this->belongsTo(Gateway::class);

    }
}
