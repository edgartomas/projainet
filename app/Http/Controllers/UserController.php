<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{


public function index()
    {
        $users = User::all();
        $title = 'List users';

        return view('users.list', compact('title', 'users'));
    }


}
   
