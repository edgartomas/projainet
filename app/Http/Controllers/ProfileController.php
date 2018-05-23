<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function index(Request $request){

        $title = "List of profiles";

        $users = User::select();

        if($request->has('name')){
            $users = $users->where('name', 'LIKE', '%'.$request->query('name').'%');
        }

        $users = $users->paginate(10);

        return view('profiles.list', compact('title', 'users'));
    }
}
