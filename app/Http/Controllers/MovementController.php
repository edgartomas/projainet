<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;

class MovementController extends Controller
{
    public function indexMovements()
    {

    		$user =Auth::user();
         $movements = Movement::all();
            $title = 'List of Moviments';

            return view('home', compact('title', 'movements'));
        
    }
}
