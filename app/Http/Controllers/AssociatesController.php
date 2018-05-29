<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Rules\ValidateNotMyself;

class AssociatesController extends Controller
{

    public function index(){

        $title = 'List associates';

        $users = Auth::user()->associate();

        $users = $users->paginate(10);

        return view('associates.listAssociate', compact('title','users'));
    }

    public function create(Request $request){

        $associated_user_id = $request['associated_user'];

        $request->validate([
            'associated_user' => 'required|exists:users,id',
        ]);

        if($request['associated_user'] == Auth::user()->id){
            return back()->withErrors(['associated_user' => 'You can associate to yourself']);
        }

        if(Auth::user()->isAlreadyAssociate($request['associated_user'])){
            return back()->withErrors(['associated_user' => 'You can associate to an associate member']);
        }

        if(Auth::user()->cannot('do-operation', $associated_user_id)){
            return abort(403, 'Access denied.');
        }

        Auth::user()->associate()->attach(['associated_user_id'=>$associated_user_id]);

        return back()->with('status', 'Users associated.');
    }

    public function destroy($id){

        if(Auth::user()->cannot('do-operation', $id)){
            return abort(403, 'Access denied.');
        }

        $user = User::findOrFail($id);

        if(Auth::user()->id == $user->id){
            return back()->withErrors('You cannot desassociate with yourself.');
        }

        if(!Auth::user()->isAlreadyAssociate($id)){
            return abort(404, 'User not found in your associates list');
        }

        Auth::user()->associate()->detach($id);

        return back()->with('status', 'Users dessociated.');
    }
}
