<?php

namespace App\Http\Controllers;
use \Auth;
use \App\Inventory;
use \App\Match;
use \App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()){
              return view("need-to-be-logged-in");
        }
        $emojis_in_inventory = Inventory::where('user_id', Auth::user()->id)->where('emoji_slot', '>', 0)->get();
        if (count ($emojis_in_inventory)<Auth::user()->emoji_slots) {
            return redirect(route("inventory.index"));
        } else if (count ($emojis_in_inventory)>Auth::user()->emoji_slots) {
            trigger_error ("User #" . Auth::user()->id . " Has more emoji's in their inventory than their currently allocated slots.");
        }
        $matches = Match::where("playerOne", Auth::user()->id)->whereNull("status")->orWhere ("playerTwo", Auth::user()->id)->whereNull("status")->get();
        if (Auth::user()->state=!0) {
            $user=User::find(Auth::user()->id);
            $user->state=0;
            $user->save();
        }
        return view('home', ["matches"=>$matches]);
    }
}
