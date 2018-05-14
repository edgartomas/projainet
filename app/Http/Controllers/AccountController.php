<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
         $accounts = Account::all();


            $title = 'List of Moviments';

            return view('home', compact('title', 'accounts'));       
    }

     public function UserAccount($owner_id)
    {
        
        $account = Account::find($owner_id);
        $title = 'List users';


        return view('home', compact('title', 'account'));  // temos que passar o titulo , não esquecer
    
    }
}
