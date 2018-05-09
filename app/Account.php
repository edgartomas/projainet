<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
   protected $fillable = [
        'owner_id', 'account_type_id', 'date', 'current_balance', 'start_balance' , 'description', 'deleted_at' , 'created_at'
    ];

    protected $hidden = [
        'code', 'current_balance', 'last_movement_date'
    ];
}
