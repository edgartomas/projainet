<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    public function index()
    {
         $accounts = Account::paginate(10);
            $title = 'List of Moviments';

            return view('home', compact('title', 'accounts'));
        
    }
}
