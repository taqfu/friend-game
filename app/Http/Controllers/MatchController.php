<?php

namespace App\Http\Controllers;
use Auth;
use App\Friend;
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
       $are_they_already_friends = !empty(Friend::where('a', $match->playerOne)->where('b', $match->playerTwo)->first());
       if ($are_they_already_friends){
          trigger_error("Player #" . $match->playerOne . " and player #" . $match->playerTwo . " are already friends. ");
       }
       if ($match->status==null){
         $match->status = $player_num+4;
         $match->save();
         return back();
       }
       if (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)){

          $match->status=10;
          $match->save();
          for ($i=0;$i<2;$i++){
              $user_id = $i==0 ? $match->playerOne : $match->playerTwo;
              Inventory::add_emoji_slot($user_id);
              $user = User::find($user_id);
              $user->points+=$match->wager;
              $user->emoji_slots++;
              $user->save();
              $friend = new Friend;
              $friend->a = $i==0 ? $match->playerOne : $match->playerTwo;
              $friend->b = $i==0 ? $match->playerTwo : $match->playerOne ;
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
          $user->points+= $match->wager==0 ? 1 : $match->wager * 2;
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

      if (Auth::user()->id != $match->playerOne && Auth::user()->id != $match->playerTwo){
          trigger_error("You are not involved in this match.");
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
          if ($player_num+7 == $match->status){
              $match->status -= 5;
              $winning_user_id = $player_num==2 ? $match->playerOne : $match->playerTwo;
              $user = User::find($winning_user_id);
              $user->points += $match->wager==0 ? 1 : $match->wager*2;
              $user->save();

          } else {
              $match->status=0;
              $user = User::find($match->playerOne);
              $user->points+=$match->wager;
              $user->save();
              $user = User::find($match->playerTwo);
              $user->points+=$match->wager;
              $user->save();
          }
          $match->save();
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
    public function menu($id){
        if (Auth::guest()){
              return View('User/need-to-be-logged-in');
        }
        $match = Match::find($id);
        if (Auth::user()->id != $match->playerOne && Auth::user()->id != $match->playerTwo){
            trigger_error("You are not involved in this match.");
        }
        return view('Match.menu', ["match"=>$match]);
    }
    public function new_msgs($id, $num_of_old_msgs){
        $match = Match::find($id);
        $messages = Msg::where('match_id', $id)->orderBy('created_at', 'desc')->take(Match::fetch_num_of_msgs($id)-$num_of_old_msgs)->get();
        return view('Msg.index', ['messages'=>$messages, "match"=>$match]);
    }
    public function searching($wager){
      //move this to match controller
	    if (Auth::guest()){
            return View('User/need-to-be-logged-in');
	    }
        if ($wager>Auth::user()->points && Auth::user()->status!=2){
            return View('User/not-enough-points');
        }
        //going to need to check every minute and if user hasn't accessed site, change status back
        if(Auth::user()->status==0){
	        $user = User::find(Auth::user()->id);
	        $user->status=1;
            $user->save();
        } else if (Auth::user()->status==1){
            if (time()- strtotime(Auth::user()->updated_at) > 60){
	            $user = User::find(Auth::user()->id);
	            $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
            }
        } else if (Auth::user()->status==2){
            $match = Match::whereNull("playerTwo_entered_at")->where('playerTwo', Auth::user()->id)->whereNull('status')->first();
            $match->playerTwo_entered_at = date("Y-m-d H:i:s");
            $match->save();
            $user = User::find(Auth::user()->id);
            $user->status=0;
            $user->save();
            return redirect(route("match.show", ['id'=>$match->id]));

        }
        $matched_user = User::where('id', '!=', Auth::user()->id)->where('status', 1)->inRandomOrder()->first();
        if (!empty($matched_user)){
            $are_they_already_friends = !empty(Friend::where('a', Auth::user()->id)->where('b', $matched_user->id)->first());
        }
        if (!empty($matched_user && !$are_they_already_friends)){

          $are_they_already_matched =
            count(Match:: whereNull('status')
              ->where ("playerOne",$matched_user->id)->where("playerTwo", Auth::user()->id)->get ())>0
            || count(Match:: whereNull('status')
              ->where ("playerOne",Auth::user()->id)->where("playerTwo", $matched_user->id)->get ())>0;


          if (!$are_they_already_matched){

              $matched_user->status=2;
              $matched_user->points-=$wager;
              $matched_user->save();
  	          $user = User::find(Auth::user()->id);
  	          $user->status=0;
              $user->points-=$wager;
              $user->save();
              $match = new Match;
              $match->playerOne = Auth::user()->id;
              $match->playerTwo = $matched_user->id;
              $match->wager = $wager;
              $match->save();
              return redirect()->action('MatchController@show', ['id'=>$match->id]);
          }
        }
	    return View('User/searching', ['matched_user'=>$matched_user, 'wager'=>$wager]);

    }

    public function status($id){
        if (Auth::guest()){
              return View('User/need-to-be-logged-in');
        }
        $match = Match::find($id);
        if (Auth::user()->id != $match->playerOne && Auth::user()->id != $match->playerTwo){
            trigger_error("You are not involved in this match.");
        }
        echo json_encode([$match->status, Match::fetch_num_of_msgs($match->id)]);
    }
    public function status_msg($id){
      if (Auth::guest()){
            return View('User/need-to-be-logged-in');
      }
      $match = Match::find($id);
      if (Auth::user()->id != $match->playerOne && Auth::user()->id != $match->playerTwo){
          trigger_error("You are not involved in this match.");
      }
        $match = Match::find($id);
        return view ("Match.statusMsg", ["match"=>$match]);
    }
}
