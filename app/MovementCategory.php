<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementCategory extends Model
{
    
    protected $fillable = [
        'name', 'type'
    ];
}
