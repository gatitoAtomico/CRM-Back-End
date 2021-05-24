<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    protected $fillable = [
        'user_id', 'role'
    ];

}
