<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{

    public function index($user)
    {   
        if(Auth::user()->can('view-account', $user)){
            $user = User::findOrFail($user);
            $accounts = $user->accounts()->withTrashed()->with('accountType')->paginate(10);
            $title = 'List of all accounts - ' . $user->name;
            return view('accounts.all', compact('title','accounts', 'user'));   
        } else {
            return abort(403, 'Access denied.');
        } 
    }

    public function create(){
        $title = 'Account creation';
        return view('accounts.create', compact('title'));
    }

    public function store(Request $request){

        $account = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'date' => 'nullable|date',
            'code' => [
                'required',
                'string',
                Rule::unique('accounts')->where(function($query){
                    return $query->where('owner_id', Auth::user()->id);
                }),
            ],
            'description' => 'nullable|string|max:255',
            'start_balance' => 'required|numeric',
        ]);

        if(empty($account['date'])){
            $account['date'] = date("Y-m-d");
        } else {
            $account['date'] = date("Y-m-d", strtotime($account['date']));
        }


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
            return abort(403, 'Access denied.');
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
                $rules['code'] = [
                                'required',
                                'string',
                                Rule::unique('accounts')->where(function($query){
                                    return $query->where('owner_id', Auth::user()->id);
                                }),
                            ];
            }
    
            $account = $request->validate($rules);

            if($account['start_balance'] != $accountModel->start_balance){

                $movements = $accountModel->movements()->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();

                if($movements->isEmpty() || $accountModel->last_movement_date == null){
                    $account['current_balance'] = $account['start_balance'];
                }
                
                if($movements->isNotEmpty()){

                    $account['current_balance'] = $accountModel->current_balance + ($account['start_balance'] - $accountModel->start_balance);

                    for($i = 0; $i < $movements->count(); $i++){
                        $movement = $movements->get($i);
                        
                        if($i == 0){
                            $movement->start_balance = $account['start_balance'];
                            if($movement->type == "expense"){
                                $movement->end_balance = $account['start_balance'] - $movement->value;
                            } else {
                                $movement->end_balance = $account['start_balance'] + $movement->value;
                            }
                            
                        } else {
                            $movementAnt = $movements->get($i - 1);

                            $movement->start_balance = $movementAnt->end_balance;
                            if($movement->type == "expense"){
                                $movement->end_balance = $movementAnt->end_balance - $movement->value;
                            } else {
                                $movement->end_balance = $movementAnt->end_balance + $movement->value;
                            }
                            
                        }
                        $movement->save();
                    }
                }
            }
    

            $accountModel->fill($account);
            $accountModel->save();
            return redirect()->route('accounts.opened', Auth::user())->with('status', 'Account updated');
            

        } else {
            return abort(403, 'Access denied.');
        }
    }

    public function opened($user){
        if(Auth::user()->can('view-account', $user)){
            $user = User::findOrFail($user);
            $accounts = $user->accounts()->with('accountType')->paginate(10);
            $title = 'List of open accounts - ' . $user->name;
            return view('accounts.open', compact('title','accounts', 'user'));
        } else {
            return abort(403, 'Access denied.');
        }
    }

    public function closed($user){
        if(Auth::user()->can('view-account', $user)){
            $user = User::findOrFail($user);
            $accounts = $user->accounts()->onlyTrashed()->with('accountType')->paginate(10);
            $title = 'List of closed accounts - ' . $user->name;
            return view('accounts.close', compact('title','accounts', 'user'));
        } else {
            return abort(403, 'Access denied.');
        } 
    }

    public function close($account){
        $account = Account::findOrFail($account);
        if(Auth::user()->can('edit-account', $account->owner_id)){
            $account->delete();
            return back()->with('status', 'Account closed.');
        } else{
            return abort(403, 'Access denied.');
        }
    }

    public function reopen($account){
        $account = Account::withTrashed()->findOrFail($account);
        if(Auth::user()->can('edit-account', $account->owner_id)){
            $account->restore();
            return back()->with('status', 'Account re-opened.');
        } else{
            return abort(403, 'Access denied.');
        }
    }

    public function destroy($account){
        $account = Account::withTrashed()->findOrFail($account);

        if(Auth::user()->can('edit-account', $account->owner_id)){
            if(!$account->haveMovements() && empty($account->last_movement_date)){
                $account->forceDelete();
                return back()->with('status', 'Account removed.');
                
            }
        }
        return abort(403, 'Access denied.');
    }

}
