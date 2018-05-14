<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;

class AccountController extends Controller
{
    public function index()
    {   
      $user =Auth::user();
      //$accounts = $user->accounts();
         $accounts = Account::all();


            $title = 'List of Moviments';

            return view('home', compact('title', 'accounts'));       
    }


    public function Edit(Account $account)
    {
       
        return view('users.edit', compact ('account'));
    }

    public function update( Request $request, Account $account )
    {

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
    /* public function UserAccount($owner_id)
    {
        
        $account = Account::find($owner_id);
        $title = 'List users';


        return view('home', compact('title', 'account'));  // temos que passar o titulo , não esquecer
    
    }*/
}
