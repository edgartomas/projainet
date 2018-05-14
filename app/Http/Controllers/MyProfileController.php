<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;

class MyProfileController extends Controller
{
    public function index(){

        $title = 'My Profile';
        $user = User::findOrFail(Auth::user()->id);

        return view('profiles.my', compact('title', 'user'));
    }

    public function updatePassword(Request $request){

        if(!Hash::check($request->input('current_password'), Auth::user()->password)){
            return back()->withErrors("Current password is incorrect");
        }

        $user = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user['password'] = Hash::make($user['password']);

        $userModel =  User::findOrFail(Auth::user()->id);
        $userModel->fill($user);
        $userModel->save();
        return back()->with('status', 'Password updated');
    }
}
