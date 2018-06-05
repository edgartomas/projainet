<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use Lava;

class DashboardController extends Controller
{
    public function index(Request $request, $user){

        $user = User::findOrFail($user);

        if(Auth::user()->can('view-dashboard', $user)){

            $accounts = $user->allAccounts()->with('accountType')->paginate(5);
            
            $total = 0;
            $totalRevenue = 0;
            $totalExpense = 0;

            $totalCatExp = collect();
            $totalCatRev = collect();
            
            foreach($user->allAccounts as $account){
                $total += $account->current_balance;

                $movements = $account->movements()->get();

                $totalExpense = $movements->where('type', 'expense')->sum('value');
                $totalRevenue = $movements->where('type', 'revenue')->sum('value');

                if($request->has('start-date') && $request->has('end-date')){
                    $movements = $account->movements()->where('date', '>=',  date('Y-m-d', strtotime($request->input('start-date'))))->where('date', '<=', date('Y-m-d', strtotime($request->input('end-date'))))->with('movementCategory')->get();                    
                } else {
                    //Não foram passados valores pela query string
                    //Assume-se que serão apresentados os valores do mês corrente(até ao dia corrente)
                    $movements = $account->movements()->where('date', '>=',  date('Y-m-01'))->where('date', '<=', date('Y-m-d'))->with('movementCategory')->get();
                }

                foreach($movements as $movement){
                    if($movement->type == 'expense'){
                        if($totalCatExp->contains('type', $movement->movementCategory->name)){
                            $totalCatExp->where('type', $movement->movementCategory->name)->first()['value'] += $movement->value;
                        } else {
                            $totalCatExp->push(['type' => $movement->movementCategory->name, 'value' => $movement->value]);
                        }
                    } else {
                        
                        if($totalCatRev->contains('type', $movement->movementCategory->name)){
                            $totalCatRev->where('type', $movement->movementCategory->name)->first()['value'] += $movement->value;
                        } else {
                            $totalCatRev->push(['type' => $movement->movementCategory->name, 'value' => $movement->value]);
                        }
                    }
                }
                
            }


            $title = 'Dashboard - ' . $user->name;

            $dataRev = Lava::DataTable();
            $dataRev->addStringColumn('Type')
                ->addNumberColumn('Perct');

            foreach($totalCatRev as $rev){
                $dataRev->addRow(array($rev['type'], (float)$rev['value']));
            }
            Lava::PieChart('Revenue', $dataRev);

            $dataExp = Lava::DataTable();
            $dataExp->addStringColumn('Type')
                ->addNumberColumn('Percent');

            foreach($totalCatExp as $exp){
                $dataExp->addRow(array($exp['type'], (float)$exp['value']));
            }
            Lava::PieChart('Expense', $dataExp);

            return view('home', compact('title', 'accounts', 'total', 'totalRevenue', 'totalExpense', 'totalCatExp', 'totalCatRev'));
        }
       
       return abort(403, 'Access denied');
    } 
}
