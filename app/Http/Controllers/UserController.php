<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'admin']);
    }


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

            if(Auth::id() == $id){
                return redirect()->action('UserController@index')->withErrors("You can't promote yourself.");
            }
    
            $user = User::findOrFail($id);

            $user->admin = 1;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User prometed successfully.');
        }

        public function demote($id){

            if(Auth::id() == $id){
                return redirect()->action('UserController@index')->withErrors("You can't demote yourself.");
            }
    
            $user = User::findOrFail($id);

            $user->admin = 0;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User demoted successfully.');
    
        }

        public function block($id){

            if(Auth::id() == $id){
                return redirect()->action('UserController@index')->withErrors("You can't block yourself.");
            }
    
            $user = User::findOrFail($id);

            $user->blocked = 1;
    
            $user->save();
    
            return redirect()->action('UserController@index')->with('status', 'User blocked successfully.');
    
        }

        public function unblock($id){

            if(Auth::id() == $id){
                return redirect()->action('UserController@index')->withErrors("You can't unblock yourself.");
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

}
   
