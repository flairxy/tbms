<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $fillable = ['name', 'charge'];
}
