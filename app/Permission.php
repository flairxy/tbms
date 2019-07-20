<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'slug', 'description'
    ];

    public function roles() {
        return $this->belongsToMany(Role::class,'role_permissions');
    }

}
