<?php

namespace App\Http\Controllers;

use App\Card;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isUser()) {
            $orders = Auth::user()->orders()->with('user')->with('card')->get();
            return view('Orders.index_myorders', compact('orders'));
        }else{
            return redirect('home');
        }
    }

    public function indexAll()
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $orders = Order::with('user')->with('card')->get();
            return view('Orders.index_all', compact('orders'));
        }else{
            return redirect('home');
        }
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->isUser()) {
            $cards = Auth::user()->cards()->with('currency')->get();
            return view('Orders.create', compact('cards'));
        }else{
            return redirect('home');
        }
    }

    public function store()
    {
        if (Auth::check() && Auth::user()->isUser()) {
            $cards = Auth::user()->cards()->where('cards.id', '=', request('card'))->get();
            if(count($cards)){
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->card_id = request('card');
                $order->write_off = request('write_off');
                $order->order_sum = request('order_sum');
                $order->save();
                return redirect('/my_orders');
            }else{
                return redirect()->back()->withErrors(['Cannot create order', 'That card is not available!']);
            }
        }else{
            return redirect('home');
        }
    }

    public function reject($order)
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $orders = Order::where('id', '=', $order)->first();
            if($orders){
                if($orders->examined){
                    return redirect()->back()->withErrors(['Cannot reject order', 'That order is already examined!']);
                }
                $orders->examined = 1;
                $orders->approved =0;
                $orders->date_approved = date('Y-m-d');
                $orders->save();
                return redirect('/orders');
            }else{
                return redirect()->back()->withErrors(['Cannot reject order', 'That order is not available!']);
            }
        }else{
            return redirect('home');
        }
    }

    public function approve($order)
    {
        //TODO:: Что делать если карта удалена? В данной логике пополняется и списівается
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $orders = Order::where('id', '=', $order)->first();
            if($orders){
                if($orders->examined){
                    return redirect()->back()->withErrors(['Cannot approve order', 'That order is already examined!']);
                }
                DB::beginTransaction();

                try {
                    $orders->examined = 1;
                    $orders->approved =1;
                    $orders->date_approved = date('Y-m-d');
                    $orders->save();
                    $card = Card::where('id', '=', $orders->card_id)->first();
                    if($card){
                        if(($orders->write_off==1)&&($card->balance < $orders->order_sum)){
                            DB::rollback();
                            return redirect()->back()->withErrors(['Cannot reject order', 'Sum of write off is bigger than balance!']);
                        }
                        // if write_off -> -1*order_sum, else +1*order_sum
                        $card->balance += $orders->order_sum * ($orders->write_off?-1:1);
                        $card->save();
                    }else {
                        DB::rollback();
                        return redirect()->back()->withErrors(['Cannot reject order', 'Not found Card!']);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->withErrors(['Cannot reject order', 'Something went wrong!']);
                }
                return redirect('/orders');
            }else{
                return redirect()->back()->withErrors(['Cannot reject order', 'That order is not available!']);
            }
        }else{
            return redirect('home');
        }
    }
}
