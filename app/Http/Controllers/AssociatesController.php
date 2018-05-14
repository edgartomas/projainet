<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AssociatesController extends Controller
{
    public function index(){

        $title = 'List associates';

        $users = Auth::user()->associate();

        $users = $users->paginate(10);

        return view('associates.listAssociate', compact('title','users'));
    }

    public function create(Request $request){

        $id = $request->input('associated_user');

        if(Auth::user()->cannot('do-operation', $id)){
            return back()->withErrors("You can't desassociate from yourself.");
        }

        Auth::user()->associate()->attach($id);

        return back()->with('status', 'Users associated.');
    }

    public function destroy($id){
        if(Auth::user()->cannot('do-operation', $id)){
            return back()->withErrors("You can't desassociate from yourself.");
        }

        Auth::user()->associate()->detach($id);

        return back()->with('status', 'Users dessociated.');
    }
}
