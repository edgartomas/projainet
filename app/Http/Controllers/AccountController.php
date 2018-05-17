<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use App\Movement;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
      $user =Auth::user();
      //$accounts = $user->accounts();
         $accounts = Account::all();
         $movements = Movement::all();


            $title = 'List of Moviments';

            return view('home', compact('title', 'accounts'));       
    }


    public function Edit( $account)
    {
        //$account = Account::findOrFail($account);
       
        return view('users.edit', compact ('account'));
    }

    public function update( Request $request, $account )
    {
        $account = Account::findOrFail($account);

        $except = [''];
        $account->fill($request->except($except));
        $account->owner_id=Auth::user()->id;
        $account->code=$request->code;

        $account->date="20028";
        $account->touch();

        $account->save();
        return redirect()
        ->route('home');
    }
    
}
