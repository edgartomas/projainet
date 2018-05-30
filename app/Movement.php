<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'movement_category_id', 'value', 'start_balance', 'end_balance' , 'description', 'type' , 'document_id', 'date', 'created_at'
    ];

    public function account(){
        return $this->belongsTo('App\Account');
    }

    public function movementCategory()
    {
        return $this->belongsTo('App\MovementCategory');
    }

    public function document()
    {
        return $this->belongsTo('App\Documents');
    }
}
