<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                'description' => 'nullable|string|max:255',
                'document_file' => 'file|mimes:pdf,png,jpeg',
                'document_description'=> 'required_if:document_file, file',   
            ]);

            
            $movement['account_id'] = $account->id;
            $movement['date'] = date("Y-m-d", strtotime($movement['date']));
            $movement['created_at'] = now();

            $category = MovementCategory::find($movement['movement_category_id']);

            $movement['type'] = $category->type;

            $difference = $movement['value'];

            if($movement['type'] == 'expense'){
                $difference = -$difference;
            }


            if(!isset($account->last_movement_date) || $movement['date'] >= $account->last_movement_date){
                $movement['start_balance'] = $account->current_balance;

                $movement['end_balance'] = $account->current_balance + $difference;

                $account->last_movement_date = $movement['date'];
            } else {
                
                $movements = $account->movements()->where('date', '>', $movement['date'])->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();

                $movement['start_balance'] = $movements->last()->start_balance;
                $movement['end_balance'] = $movements->last()->start_balance + $difference;

                foreach($movements as $mov){
                    $mov->start_balance += $difference;
                    $mov->end_balance += $difference;
                    $mov->save();
                }
            }

            $account->current_balance += $difference;
            
            if($request->hasFile('document_file') && $request->file('document_file')->isValid()){
                $document['type'] = $request->file('document_file')->getClientOriginalExtension();
                $document['original_name'] = $request->file('document_file')->getClientOriginalName();
                $document['description'] = $movement['document_description'];
                
                //dd($document);

                $documentID = \App\Document::create($document);

                $movement['document_id'] = $documentID->id;
            }
   
            
            $account->save();
            $movCreated = Movement::create($movement);
            if(isset($documentID)){
                //$filepath = $request->file('document_file')->storeAs('documents', $account->id, $movCreated->id);
                Storage::putFileAs('documents/'.$account->id, $request->file('document_file'), $movCreated->id.'.'.$document['type']);
            }
               

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

            $difference = $movement->value;

            if($movement->type == 'revenue'){
                $difference = -$difference;
            }

            $movements = $account->movements()->where('date', '>=', $movement->date)->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();

            foreach($movements as $mov){
                $mov->start_balance += $difference;
                $mov->end_balance += $difference;
                $mov->save();
            }

            $movement->delete();

            if($movement->date == $account->last_movement_date && $movement->end_balance == $account->current_balance){
                $account->last_movement_date = $account->movements->max('date');
            }

            $account->current_balance += $difference;

            $account->save();

            return redirect()->route('movements.list', $account->id)->with('status', 'Movement deleted');
        } else {
            return abort(403, 'Access denied.');
        }

       
    }
}
