<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralCount extends Model
{
    protected $table = 'referral_interest_count';
    protected $fillable = [
        'referral_id', 'user_id', 'amount', 'count'
    ];
}
