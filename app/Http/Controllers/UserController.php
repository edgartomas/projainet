<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use App\Rules\ValidatePassword;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
        {
            $users = User::select();

            if($request->has('name')){
                $users = $users->where('name', 'LIKE', '%'.$request->query('name').'%');
            }

            if($request->has('type')){
                if($request->query('type') == 'admin'){
                    $users = $users->where('admin', 1);
                }
                
                if($request->query('type') == 'normal'){
                    $users = $users->where('admin', 0);
                }
            }

            if($request->has('status')){
                if($request->query('status') == 'blocked'){
                    $users = $users->where('blocked', 1);
                }
                
                if($request->query('status') == 'unblocked'){
                    $users = $users->where('blocked', 0);
                }
            }

            $users = $users->paginate(10);
            $title = 'List of users';

            return view('users.list', compact('title', 'users'));
        }
        
        public function promote($id){

            if(Auth::user()->cannot('do-operation', $id)){
                return abort(403, 'Access denied.');
            }
    
            $user = User::findOrFail($id);

            $user->admin = 1;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User prometed successfully.');
        }

        public function demote($id){

            if(Auth::user()->cannot('do-operation', $id)){
                return abort(403, 'Access denied.');
            }
    
            $user = User::findOrFail($id);

            $user->admin = 0;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User demoted successfully.');
    
        }

        public function block($id){

            if(Auth::user()->cannot('do-operation', $id)){
                return abort(403, 'Access denied.');
            }
    
            $user = User::findOrFail($id);

            $user->blocked = 1;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User blocked successfully.');
    
        }

        public function unblock($id){

            if(Auth::user()->cannot('do-operation', $id)){
                return abort(403, 'Access denied.');
            }
    
            $user = User::findOrFail($id);

            $user->blocked = 0;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User unblocked successfully.');
    
        }


    public function create()
        {
            $user = new User();
            $title = 'Adicionar Movimento';

            return view('users.add', compact('user', 'title'));

        }

    public function edit(){
        $title = 'My Profile';
        $user = User::findOrFail(Auth::user()->id);
        return view('profiles.my', compact('title', 'user'));
    }

    public function update(Request $request){

        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z .]+$/',
            'phone' => 'nullable',
            'profile_photo' => 'image'
        ];

        if($request['email'] != Auth::user()->email){
            $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        $user = $request->validate($rules);


        if($request->hasfile('profile_photo') && $request->file('profile_photo')->isValid()){

            
            $filepath = $request->file('profile_photo')->store('profiles', 'public');

            $user['profile_photo'] = basename($filepath);
            
        }

        $userModel =  User::findOrFail(Auth::user()->id);
        $userModel->fill($user);
        $userModel->save();

        return back()->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request){

        $user = $request->validate([
            'old_password' => ['required', new ValidatePassword(auth()->user())],
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user['password'] = Hash::make($user['password']);

        $userModel =  User::findOrFail(Auth::user()->id);
        $userModel->fill($user);
        $userModel->save();
        return back()->with('status', 'Password updated');
    }


    

}
   
