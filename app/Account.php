<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Account extends Model
{
    use SoftDeletes;

    public $timestamps = false;

   protected $fillable = [
         'account_type_id', 'current_balance', 'start_balance' , 'description', 'deleted_at' , 'created_at', 'owner_id', 'date', 'code', 'last_movement_date'
    ];

    public function owner(){
        return $this->belongsTo('App\User', 'owner_id');
    }
    
    public function accountType()
    {
        return $this->belongsTo('App\AccountType');
    }

    public function movements(){
        return $this->hasMany('App\Movement');
    }

    public function numberMovements(){
        return $this->movements()->count();
    }

    public function haveMovements(){
        return $this->movements()->count() > 0;
    }

}
