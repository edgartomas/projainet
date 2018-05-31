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

            $accounts = $user->allAccounts()->with('accountType')->paginate(2);
            
            $total = 0;
            $totalRevenue = 0;
            $totalExpense = 0;

            
            foreach($user->allAccounts as $account){
                $total += $account->current_balance;
                $totalRevenue += $account->movements()->whereType('revenue')->sum('value');
                $totalExpense += $account->movements()->whereType('expense')->sum('value');
            }

            $title = 'Dashboard - ' . $user->name;

            return view('home', compact('title', 'accounts', 'total', 'totalRevenue', 'totalExpense'));
        }
       
       return abort(403, 'Access denied');
    } 
}
