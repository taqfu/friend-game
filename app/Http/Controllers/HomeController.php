<?php

namespace App\Http\Controllers;
use \Auth;
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
        $matches = Match::where ("playerOne", Auth::user()-> id)->orWhere ("playerTwo", Auth::user()-> id)->whereNull("status")->get();
        if (Auth:: user () ->state=! 0) {
          $user=User::find(Auth:: user () -> id);
          $user ->state=0;
          $user->save();
        }
        return view('home', ["matches"=>$matches]);
    }
}
