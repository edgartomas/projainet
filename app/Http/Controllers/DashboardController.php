<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;

class DashboardController extends Controller
{
    public function index($user){

        $user = User::findOrFail($user);

        if(Auth::user()->can('view-dashboard', $user)){

            $accounts = $user->allAccounts;

            $total = $accounts->sum('current_balance');

            $totalRevenue = 0;
            $totalExpense = 0;

            foreach($accounts as $account){
                $totalRevenue += $account->movements()->whereType('revenue')->sum('value');
            }

            foreach($accounts as $account){
                $totalExpense += $account->movements()->whereType('expense')->sum('value');
            }

            //$totalRevenue = $accounts->movements->where('type', 'LIKE', 'revenue')->get();

            $title = 'Dashboard - ' . $user->name;

            return view('home', compact('title', 'accounts', 'total', 'totalRevenue', 'totalExpense'));
        }
       
       return abort(403, 'Access denied');
    } 
}
