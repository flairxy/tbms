<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = ['user_id', 'parent_id', 'parent_ref_link'];
}
