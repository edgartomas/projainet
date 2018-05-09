<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;

class MovementController extends Controller
{
    public function indexMovements()
    {
         $movements = Movement::paginate(10);
            $title = 'List of Moviments';

            return view('home', compact('title', 'movements'));
        
    }
}
