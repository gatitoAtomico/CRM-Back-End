<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Transactions extends Model
{
    //
    protected $casts = [
        'created_at' => 'datetime:d/m/Y', // Change your format
        'updated_at' => 'datetime:d/m/Y',
    ];

    protected $fillable = [
        'user_id', 'amount' , 'avatar',
    ];


}
