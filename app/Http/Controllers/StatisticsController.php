<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $orders = Order::where('examined','=','1')
                ->where('approved', '=', '1')
                ->groupBy('date_approved')->orderBy('date_approved', 'desc')
                ->select('date_approved', DB::raw('SUM(write_off * order_sum) as day_write_off'), DB::raw('SUM((1-write_off)*order_sum) as day_replenish'))
                ->get();
            return view('Statistics.index', compact('orders'));
        }else{
            return redirect('home');
        }
    }

    public function show($user)
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $orders = Order::where('user_id', '=', $user)
                ->where('examined','=','1')
                ->where('approved', '=', '1')
                ->groupBy('date_approved')->orderBy('date_approved', 'desc')
                ->select('date_approved', DB::raw('SUM(write_off * order_sum) as day_write_off'), DB::raw('SUM((1-write_off)*order_sum) as day_replenish'))
                ->with('user')
                ->get();
            $users = User::where('id', '=', $user)->first();
            if(!$users){
                return redirect('/statistics')->withErrors(['Cannot show statistics', 'No information about User!']);
            }
            return view('Statistics.show', compact('orders', 'users'));
        }else{
            return redirect('home');
        }
    }

    public function index_my()
    {
        if (Auth::check() && Auth::user()->isUser()) {
            $orders = Auth::user()->orders()
                ->where('examined','=','1')
                ->where('approved', '=', '1')
                ->where('write_off', '=', '0')
                ->with('user')
                ->groupBy('date_approved','user_id')->orderBy('date_approved', 'desc')
                ->select('user_id', 'date_approved', DB::raw('SUM(order_sum) as day_sum'))
                ->get();
            return view('Statistics.index_my', compact('orders'));
        }else{
            return redirect('home');
        }
    }
}
