<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use App\MovementCategory;

class MovementController extends Controller
{
    public function index($account)
    {	

        $account = Account::findOrFail($account);

        if(Auth::user()->can('view-movement', $account->owner->id)){

            $movements = Movement::where('account_id', '=' , $account->id)->orderBy('date', 'desc')->orderBy('created_at', 'desc')->with('movementCategory')->paginate(10);

            $title = 'List of Moviments';

            return view('movements.list', compact('title', 'movements', 'account'));
        } else {
            return abort(403, 'Access denied.');
        }
        
    }

    public function create($account){

        $account = Account::findOrFail($account);

        if(Auth::user()->can('add-movement', $account->owner_id)){
            $title = 'Movement creation';
            $categories = MovementCategory::all();
            return view ('movements.create', compact('title', 'categories', 'account'));
        } else {
            return abort(403, 'Access denied.');
        } 
    }

    public function store(Request $request, $account){

        $account = Account::findOrFail($account);

        if(Auth::user()->can('add-movement', $account->owner_id)){

            $movement = $request->validate([
                'movement_category_id' => 'required|Exists:movement_categories,id',
                'date' => 'required|date|before:tomorrow',
                'value' => 'required|numeric|min:0.01',
                'description' => 'nullable|string',
                'document_description'=> 'required_if:document_file, file',
                'document_file' => 'file|mimes:pdf, png, jpeg',
                
            ]);

            $movement['account_id'] = $account->id;
            $movement['date'] = date("Y-m-d", strtotime($movement['date']));
            $movement['created_at'] = date('Y-m-d H:i:s');

            $category = MovementCategory::find($movement['movement_category_id']);

            $movement['type'] = $category->type;

            if(!isset($account->last_movement_date) || $movement['date'] >= $account->last_movement_date){
                $movement['start_balance'] = $account->current_balance;
                if($movement['type'] == 'expense'){
                    $movement['end_balance'] = $accountModel['current_balance'] = $account->current_balance - $movement['value'];
                } else {
                    $movement['end_balance'] = $accountModel['current_balance'] = $account->current_balance + $movement['value'];
                }
                $accountModel['last_movement_date'] = $movement['date'];
            } else {
                $movements = Movement::where('account_id', $account->id)->where('date', '>', $movement['date'])->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();

                for($i = 0; $i < $movements->count(); $i++){
                    if($i == 0){
                        $movement['start_balance'] = $movements->get($i)->start_balance;
                        if($movement['type'] == 'expense'){
                            $movement['end_balance'] = $movement['start_balance'] - $movement['value'];
                        } else {
                            $movement['end_balance'] = $movement['start_balance'] + $movement['value'];
                        }
                        $movements->get($i)->start_balance = $movement['end_balance'];
                        $movements->get($i)->end_balance = $movement['end_balance'] + $movements->get($i)->value;
                    } else {
                        $movements->get($i)->start_balance = $movements->get($i-1)->end_balance;
                        if($movement['type'] == 'expense'){
                            $movements->get($i)->end_balance = $movements->get($i)->start_balance - $movements->get($i)->value;
                        } else {
                            $movements->get($i)->end_balance = $movements->get($i)->start_balance + $movements->get($i)->value;
                        }

                    }
                    $movements->get($i)->save();
                }
                $accountModel['current_balance'] = $movements->last()->end_balance;
            }

            $account->fill($accountModel);
            $account->save();
            Movement::create($movement);

            return redirect()->route('movements.list', $account->id)->with('status', 'Movement created');
        } else {
            return abort(403);
        } 
    }   

    public function Edit($movement)
    {

        $movement = Movement::findOrFail($movement);

        if(Auth::user()->can('edit-movement', $movement->account->owner_id)){
        $categories = MovementCategory::all();
        $title = 'Edit Movement';
       
        return view('movements.edit', compact ('movement', 'title', 'categories'));
        }

        return abort(403, 'Access denied');
        
    }

    public function destroy($movement){

        $movement = Movement::findOrFail($movement);

        if(Auth::user()->can('remove-movement', $movement)){
            $account = $movement->account;
            if($account->numberMovements() > 1){
                if($movement->date == $account->last_movement_date && $movement->end_balance == $account->current_balance){
                    //Estamos a eliminar o ultimo movimento feito
                    $mov = Movement::where('account_id', $account->id)->where('date', '<', $movement['date'])->orderBy('date', 'desc')->first();
                    $account->last_movement_date = $mov->date;
                    $account->current_balance = $mov->end_balance;
                } else {
                    $movements = Movement::where('account_id', $account->id)->where('date', '>', $movement['date'])->orderBy('date', 'asc')->get();
                    for($i = 0; $i < $movements->count(); $i++){
                        $mov = $movements->get($i);
                        if($i == 0){
                            $mov->start_balance = $movement->start_balance;
                            $mov->end_balance = $movement->start_balance + $mov->value;
                        } else {
                            $movAnt = $movements->get($i - 1);
                            $mov->start_balance = $movAnt->end_balance;
                            $mov->end_balance = $movAnt->end_balance + $mov->value;
                        }
                        $mov->save();
                    }
                    $account->current_balance = $movements->last()->end_balance;
                }
            } else {
                $account->current_balance = $movement->start_balance;
                $account->last_movement_date = null;
            }
            $account->save();
            $movement->delete();
            return redirect()->route('movements.list', $account->id)->with('status', 'Movement deleted');
        }

        return abort(403, 'Access denied.');
    }
}
