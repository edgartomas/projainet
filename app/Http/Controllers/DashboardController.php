<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\User;

class DashboardController extends Controller
{
    public function index($user){

        $user = User::findOrFail($user);

       
            $accounts = Account::all();

            $title = 'List of Moviments';
    
            return view('home', compact('title', 'accounts'));
        

       
    } 
}
