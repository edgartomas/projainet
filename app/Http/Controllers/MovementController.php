<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;

class MovementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexMovements($account)
    {

    		
         $movements = Movement::where('account_id', '=' , $account)->get();

            $title = 'List of Moviments';

            return view('users.listmovements', compact('title', 'movements'));
        
    }

     public function Edit(Account $account)
    {
       
        return view('users.listmovements', compact ('account_id'));
    }
}
