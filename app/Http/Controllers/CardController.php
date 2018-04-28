<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Card;
use App\Currency;

class CardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $cards = Card::with('user')->with('currency')->where('deleted', '=', '0')->get();
            return view('Cards.index', compact('cards'));
        }else{
            return redirect('home');
        }
    }

    public function show($card)
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $cardInfo = Card::where('id',$card)
                ->with('user')->with('currency')
                ->get();
            $users = User::all();
            $currencies = Currency::all();
            return view('Cards.show', compact('cardInfo', 'users', 'currencies'));
        }else{
            return redirect('home');
        }
    }

    public function showUserCards(){
        if (Auth::check() && Auth::user()->isUser()) {
            $cards = Auth::user()->cards()->with('currency')->get();
            //dd($cards);
            return view('Cards.index_mycards', compact('cards'));
        }else{
            return redirect('home');
        }
    }

    public function detachUserCard($card){
        if (Auth::check() && Auth::user()->isUser()) {
            $cardOrders = Auth::user()->cards()->where('cards.id', '=', $card)->with('orders')->first();
            if($cardOrders){
                if($cardOrders->balace==0){
                    foreach ($cardOrders['orders'] as $order){
                        if($order->examined == 0){
                            return redirect()->back()->withErrors(['Cannot detach this card', 'Unexamined orders!']);
                        }
                    }
                    $cardOrders->user_id=0;
                    $cardOrders->save();
                    return redirect('/my_cards');
                }
                else{
                    return redirect()->back()->withErrors(['Cannot detach this card', 'Card balance is not 0(zero)!']);
                }
            }else{
                return redirect()->back()->withErrors(['Cannot detach this card', 'Card not found!']);
            }
            return redirect('/my_cards');
        }else{
            return redirect('home');
        }
    }

    public function newCard(){
        $users = User::all();
        $currencies = Currency::all();
        return view('Cards.create', compact('users', 'currencies'));
    }
    public function store($card, Request $request)
    {
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $this->saveCard($card, $request);
            return redirect('/cards');
        }else {
            return redirect('home');
        }
    }

    public function create(Request $request){
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $this->saveCard(null, $request);
            return redirect('/cards');
        }else {
            return redirect('home');
        }
    }

    public function destroy($card){
        if (Auth::check() && Auth::user()->isAdministrator()) {
            $cardInfo = Card::find($card);
            //If card exist - then delete
            if($cardInfo){
                if($cardInfo->balance==0){
                    $cardInfo->deleted=1;
                    $cardInfo->save();
                }else{
                    return redirect()->back()->withErrors(['Cannot delete this card', 'Balance is not 0(zero)!']);
                }
            }else{
                return redirect()->back()->withErrors(['Cannot delete this card', 'Card not found!']);
            }
            return redirect('/cards');
        }else {
            return redirect('home');
        }
    }

    private function saveCard($card, Request $request)
    {
        $validatedData = $request->validate([
            'card_number' => 'required|digits:16',
            'cw2' => 'required|digits:3',
            'issue_to' => 'required|date',
        ]);
        $Card = null;
        if ($card == null) {
            $Card = new Card();
        } else {
            $Card = Card::where('id', $card)->first();
        }
        if ($Card === null) { //if nothing found - go to list of all cards
            return false;
        }
        $Card->card_number = base64_encode(request('card_number'));
        $Card->cw2 = base64_encode(request('cw2'));
        $Card->issue_to = request('issue_to');
        $Card->user_id = request('user_id');
        $Card->currency_id = request('currency');

        $Card->save();
        return true;
    }

}
