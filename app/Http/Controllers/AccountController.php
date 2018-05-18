<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($user)
    {   
        $accounts = Account::withTrashed()->where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of all accounts';
        return view('accounts.all', compact('title','accounts'));       
    }

    public function create(){
        $title = 'Account creation';
        return view('accounts.create', compact('title'));
    }

    public function store(Request $request){

        $account = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'date' => 'required|date',
            'code' => 'required|string|min:6|max:255|unique:accounts,code,'.Auth::user()->id,
            'description' => 'nullable|string|max:255',
            'start_balance' => 'required|numeric',
        ]);

        $account['date'] = date("Y-m-d", strtotime($account['date']));
        $account['current_balance'] = $account['start_balance'];
        $account['owner_id'] = Auth::user()->id;
        $account['created_at'] = date("Y-m-d H:i:s");

        Account::create($account);

        return redirect()->route('accounts.opened', Auth::user())->with('status', 'Account created');
    }


    public function Edit( $account)
    {
        
        $title = 'Edit account';
        $account = Account::findOrFail($account);

        if(Auth::user()->can('edit-account', $account->owner_id)){
            return view('accounts.edit', compact ('account', 'title'));
        } else {
            return back()->withErrors("You can't edit this account");
        } 
    }

    public function update(Request $request, $account)
    {
        $accountModel = Account::withTrashed()->findOrFail($account);

        if(Auth::user()->can('edit-account', $accountModel->owner_id)){
            $rules = [
                'account_type_id' => 'required|exists:account_types,id',
                'description' => 'nullable|string|max:255',
                'start_balance' => 'required|numeric',
            ];
    
            if($request['code'] != $accountModel->code){
                $rules['code'] = 'required|string|min:6|max:255|unique:accounts,code,'.Auth::user()->id;
            }
    
            $acc = $request->validate($rules);
    
            if(isset($accountModel->last_movement_update)){
    
            } else {
                $acc['current_balance'] = $acc['start_balance'];
            }
            
            $accountModel->fill($acc);
            $accountModel->save();
    
            return redirect()->route('accounts.opened', Auth::user())->with('status', 'Account updated');
        } else {
            return back()->withErrors("You can't edit this account");
        }
    }

    public function opened($user){
        $accounts = Account::where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of open accounts';
        return view('accounts.open', compact('title','accounts'));
    }

    public function closed($user){
        $accounts = Account::onlyTrashed()->where('owner_id', '=', $user)->with('accountType')->paginate(10);
        $title = 'List of closed accounts';
        return view('accounts.close', compact('title','accounts'));
    }

    public function close($account){
        $account = Account::findOrFail($account);
        if(Auth::user()->can('edit-account', $account->owner_id)){
            $account->delete();
            return back()->with('status', 'Account closed.');
        } else{
            return back()->withErrors("You can't close this account");
        }
    }

    public function reopen($account){
        $account = Account::withTrashed()->findOrFail($account);
        if(Auth::user()->can('edit-account', $account->owner_id)){
            $account->restore();
            return back()->with('status', 'Account re-opened.');
        } else{
            return back()->withErrors("You can't re-open this account");
        }
    }

    public function destroy($account){
        $account = Account::withTrashed()->findOrFail($account);
        if(Auth::user()->can('edit-account', $account->owner_id)){
            if(isset($account->last_movement_date)){
                return back()->withErrors('Account cannot be removed.');
            }
            $account->forceDelete();
            return back()->with('status', 'Account removed.');
        } else{
            return back()->withErrors("You can't remove this account");
        }
    }

}
