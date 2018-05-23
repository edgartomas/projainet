<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use App\Account;
use App\User;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $movements = Movement::all()->count();
        $accounts = Account::all()->count();
        $movements = Movement::all()->count();

        
    }
    
}
