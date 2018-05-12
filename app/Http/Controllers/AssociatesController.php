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
}
