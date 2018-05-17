<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use Illuminate\Support\Facades\Storage;

class MyProfileController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $title = 'My Profile';
        $user = User::findOrFail(Auth::user()->id);

        return view('profiles.my', compact('title', 'user'));
    }

    public function update(Request $request){

        $user = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|regex:/(\+351)\s[0-9]{3}\s[0-9]{3}\s[0-9]{3}|[0-9]{3}\s[0-9]{3}\s[0-9]{3}|(\+351)\s[0-9]{9}|[0-9]{9}/'
        ]);

        if($request['email'] != Auth::user()->email){
            $user = $request->validate([
                'email' => 'required|string|email|max:255|unique:users'
            ]);
        }

        if($request->hasfile('profile_photo') && $request->file('profile_photo')->isValid()){

            $user = $request->validate([
                'profile_photo' => 'image'
            ]);

            if(isset(Auth::user()->profile_photo)){
                Storage::delete('public/profiles' . Auth::user()->profile_photo);
            }
            
            $filepath = Storage::putFile('public/profiles', $request->file('profile_photo'));

            $user['profile_photo'] = basename($filepath);
            
        }

        $userModel =  User::findOrFail(Auth::user()->id);
        $userModel->fill($user);
        $userModel->save();

        return back()->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request){

        if(!Hash::check($request->input('current_password'), Auth::user()->password)){
            return back()->withErrors("Current password is incorrect");
        }

        $user = $request->validate([
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user['password'] = Hash::make($user['password']);

        $userModel =  User::findOrFail(Auth::user()->id);
        $userModel->fill($user);
        $userModel->save();
        return back()->with('status', 'Password updated');
    }
}
