<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    const UPDATED_AT = null;
    
    protected $fillable = [
        'type', 'original_name', 'description'
   ];
}
