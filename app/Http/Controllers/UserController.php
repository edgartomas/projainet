<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{


public function index()
    {

        $users = User::paginate(3);
        $title = 'List users';

        return view('users.list', compact('title', 'users'));
    }


 public function create()
    {
    	$user = new User();
    	$title = 'Adicionar Movimento';

    	return view('users.add', compact('user', 'title'));

    }

}
   
