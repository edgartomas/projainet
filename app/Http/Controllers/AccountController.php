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

            return view('home', compact('title', 'accounts', 'movements'));       
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

    public function all($user){
        $accounts = Account::withTrashed()->where('owner_id', '=', $user)->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.list', compact('title','accounts'));
    }

    public function opened($user){
        $accounts = Account::where('owner_id', '=', $user)->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.list', compact('title','accounts'));
    }

    public function closed($user){
        $accounts = Account::onlyTrashed()->where('owner_id', '=', $user)->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.list', compact('title','accounts'));
    }

    public function close($account){
        Account::findOrFail($account)->delete();
        return back()->with('status', 'Account closed.');
    }

    public function reopen($account){
        Account::withTrashed()->findOrFail($account)->restore();
        return back()->with('status', 'Account re-opened.');
    }

    public function destroy($account){

        if(!isset($account->last_movement_date) || !$account->trashed()){
            return back()->withErrors('Account cannot be removed.');
        }

        if(isset($account->last_movement_data)){
            //$account->movements->
        }

        Account::detroy($account);

        return back()->with('status', 'Account removed.');
    }
}
