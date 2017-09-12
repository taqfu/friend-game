<?php

namespace App\Http\Controllers;
use Auth;
use App\Inventory;
use App\Match;
use App\Msg;
use App\User;

use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
     public function friend($id){
       $match = Match::find($id);
       if (Auth::guest()){
             return View('User/need-to-be-logged-in');
       }
       $player_num = Match::which_player_are_they($match, Auth::user()->id);
       if (!$player_num){
           trigger_error("Player #" . Auth::user()->id . " is trying to become friends in a match that they're not even playing.");
       }
       if ($match->status!=null && $match->status != 5 && $match->status!=6){
         trigger_error("Player #" . Auth::user()->id . " is trying to become friends in a match but its not the appropriate status for that.");
       }
       if ($match->status == $player_num+4){
          trigger_error("Player #" . Auth::user()->id . " is trying to become friends in a match but they've already done that.");
       }

       if ($match->status==null){
         $match->status = $player_num+4;
         $match->save();
         return back();
       }

       if (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)){
          $match->status==10;
          for ($i=0;$i<2;$i++){
              $friend = new Friend;
              $friend->a = $i==1 ? $match->playerOne : $match->playerTwo;
              $friend->b = $i==2 ? $match->playerTwo : $match->playerOne ;
              $friend->match_id = $match->id;
              $friend->save();
          }
       }
       return back();

     }
     public function cancel_friend($id){
       $match = Match::find($id);
       if (Auth::guest()){
             return View('User/need-to-be-logged-in');
       }
       $player_num = Match::which_player_are_they($match, Auth::user()->id);
       if (!$player_num){
           trigger_error("Player #" . Auth::user()->id . " is trying to cancel a friendship for a match they're not a part of.");
       }
       if ($match->status !=5 && $match->status !=6){
           trigger_error("Player #" . Auth::user()->id . " is trying to cancel a friendship but this match isn't friendly.");
       }
       if (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)){
          $match->status = $player_num;
          $match->save();
          $user = User::find(Auth::user()->id);
          $user->points+= $match->wager==0 ? 1 : $match->wager;
          $user->save();
          return back();
       }
       $match->status=null;
       $match->save();
       return back();
     }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
      /*
        if match ends, act appropriately.
      */
      if (Auth::guest()){
            return View('User/need-to-be-logged-in');
      }
        $messages = Msg::where('match_id', $match->id)->get();
        return View('Match/show', [
          'match'=>$match,
          'messages'=>$messages,
          'inventory_emojis'=>Inventory::where("user_id", Auth:: user ()->id)->where("emoji_slot", ">", 0)->orderBy("emoji_slot", "asc")->get ()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }

    public function quit ($id){
      $match = Match::find($id);
      if (Auth::guest()){
            return View('User/need-to-be-logged-in');
	    }
      $player_num = Match::which_player_are_they($match, Auth::user()->id);
      if (!$player_num){
          trigger_error("Player #" . Auth::user()->id . " is trying to quit a match that they're not even playing.");
      }
      if ($match->status==null){
          $match->status = $player_num + 7;
          $match->save();
          return back();

      } else if ($match->status ==8 || $match->status ==9){
          $match->status -= 5;
          $match->save();
          $winning_user_id = $player_num==2 ? $match->playerOne : $match->playerTwo;
          $user = User::find($winning_user_id);
          $user->points += $match->wager==0 ? 1 : $match->wager*2;
          $user->save();
          return redirect (route('home'));
      }
    }

    public function cancel_quit($id){
        $match = Match::find($id);
        if (Auth::guest()){
              return View('User/need-to-be-logged-in');
        }
        $player_num = Match::which_player_are_they($match, Auth::user()->id);
        if (!$player_num){
            trigger_error("Player #" . Auth::user()->id . " is trying to cancel quitting a match that they're not even playing.");
        }
        if ($match->status !=8 && $match->status !=9){
            trigger_error("Player #" . Auth::user()->id . " is trying to cancel quitting a match despite the fact that no one's trying to quit.");
        }
        if ($match->status!=$player_num+7){
            trigger_error("Player #" . Auth::user()->id . " is trying to cancel quitting a match even though the other player's trying to quit.");

        }
        $match->status=null;
        $match->save();
        return back();
    }
}
