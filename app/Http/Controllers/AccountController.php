<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use App\Movement;
use Illuminate\Validation\Rule;

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

    public function create(){
        $title = 'Account creation';
        return view('accounts.create', compact('title'));
    }

    public function store(Request $request){

        $account = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'date' => 'required|date_format:d/m/Y',
            'code' => [
                'required',
                'string',
                'min:6',
                'max:255',
                Rule::unique('accounts')->where(function($query){
                    return $query->where('owner_id', '<>', Auth::user());
                }),
            ],
            'description' => 'nullable|string|max:255',
            'start_balance' => 'required|numeric',
        ]);

        $account['date'] = date("Y-m-d", strtotime($account['date']));

        $account['owner_id'] = Auth::user()->id;
        $account['created_at'] = date("Y-m-d H:i:s");

        Account::create($account);

        return redirect()->route('accounts.opened', Auth::user())->with('status', 'Account created');
    }


    public function Edit( $account)
    {
        $account = Account::findOrFail($account);
       
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
    


    

    public function all($user){
        $accounts = Account::withTrashed()->where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.all', compact('title','accounts'));
    }

    public function opened($user){
        $accounts = Account::where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.open', compact('title','accounts'));
    }

    public function closed($user){
        $accounts = Account::onlyTrashed()->where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.close', compact('title','accounts'));
    }

    public function close($account){
        $account = Account::withTrashed()->findOrFail($account);
        if(Auth::user()->can('do-operation', $account->owner_id)){
            return back()->withErrors("You can't close this account");
        }
        $account->delete();
        return back()->with('status', 'Account closed.');
    }

    public function reopen($account){
        $account = Account::withTrashed()->findOrFail($account);
        if(Auth::user()->can('do-operation', $account->owner_id)){
            return back()->withErrors("You can't re-open this account");
        }
        $account->restore();
        return back()->with('status', 'Account re-opened.');
    }

    public function destroy($account){

        $account = Account::withTrashed()->findOrFail($account);

        if(Auth::user()->can('do-operation', $account->owner_id)){
            return back()->withErrors("You can't remove this account");
        }

        if(isset($account->last_movement_date)){
            return back()->withErrors('Account cannot be removed.');
        }

        $account->forceDelete();

        return back()->with('status', 'Account removed.');
    }

}
