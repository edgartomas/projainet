<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'blocked',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function adminToString(){
        return $this->admin == 1 ? 'Admin.' : 'Normal';
    }

    public function blockedToString(){
        return $this->blocked == 0 ? 'Unblocked' : 'Blocked';
    }

    public function associate(){
        return $this->belongsToMany( User::class, 'associate_members', 'main_user_id', 'associated_user_id');
    }

    public function associateOf(){
        return $this->belongsToMany( User::class, 'associate_members', 'associated_user_id', 'main_user_id');
    }
    
}
