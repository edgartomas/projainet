<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;

class MovementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexMovements()
    {
         $movements = Movement::paginate(10);
            $title = 'List of Moviments';

            return view('home', compact('title', 'movements'));
        
    }
}
