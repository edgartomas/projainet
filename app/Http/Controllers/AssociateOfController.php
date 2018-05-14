<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AssociateOfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $title = 'List associate of';

        $users = Auth::user()->associateOf();

        $users = $users->paginate(10);

        return view('associates.listAssociateOf', compact('title','users'));
    }
}
