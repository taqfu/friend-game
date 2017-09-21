<?php

namespace App\Http\Controllers;
use \Auth;
use \App\Friend;
use \App\Inventory;
use \App\Match;
use \App\Msg;
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
              return View('User/need-to-be-logged-in');
        }
        $friend_arr = [AutH::user()->id];
        $friends = Friend::where('a', Auth::user()->id)->get();
        foreach($friends as $friend){
            $friend_arr [] = $friend->b;
        }
        return view('home', [
            "messages"=>Msg::whereIn('user_id', $friend_arr)->where('match_id', 0)->where('room_id',0)->get(),
            "num_of_friends"=>count($friends),
            'inventory_emojis'=>Inventory::where("user_id", Auth:: user ()->id)->where("emoji_slot", ">", 0)->orderBy("emoji_slot", "asc")->get ()

        ]);
    }
}
