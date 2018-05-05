<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class WelcomeController extends Controller
{
    public function index(){

        $title = "Gestão Finanças";

        $numUsers = User::count();

        return view('master', compact('title', 'numUsers'));
    }
}
