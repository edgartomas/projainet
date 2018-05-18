<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class DashboardController extends Controller
{
    public function index(){   
        $accounts = Account::all();


        $title = 'List of Moviments';

        return view('home', compact('title', 'accounts'));
    } 
}
