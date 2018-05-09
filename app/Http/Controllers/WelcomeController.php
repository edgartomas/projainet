<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Movement;
use App\Account;

class WelcomeController extends Controller
{
    public function index(){

        $title = "Gestão Finanças";

        $numUsers = User::count();

        $numMovements = Movement::count();

        $numAccounts = Account::count();

        return view('welcome', compact('title', 'numUsers', 'numAccounts', 'numMovements'));
    }
}
