<?php

namespace App;
use Auth;
use App\Msg;
use Illuminate\Database\Eloquent\Model;
/*
0 - both abandoned
1 - won
2 - won
3 - quit
4 - quit
5 - offering friendship
6 - offering friendship
8 - offering withdrawl
9 - offering withdrawl
10
*/
class Match extends Model
{
    public static function display_status_msg($id){
        $match = Match::find($id);
        $num_of_points_won  = $match->wager==0 ? 1 : $match->wager*2;
        $player_num = Match::which_player_are_they($match, Auth::user()->id);
        $other_player = User::find (Match::whos_other_player($match, Auth::user()->id));

        if ($match->status==1 || $match->status==2){
            return $player_num==$match->status ? "You won $num_of_points_won points." : "You lost $match->wager points.";
        } else if ($match->status==3 || $match->status==4){
            return $player_num+2==$match->status ? "You quit and lost $match->wager points." : "They quit and you won $num_of_points_won points.";
        } else if ($match->status===0 && $match->status!==999){
            return "Both players quit.";
        } else if ($match->status==10){
              return "You became friends with $other_player->username.";
        }
        return "ongoing";


    }
    public static function does_user_have_active_match(){
        return (count(Match:: where("status", ">", 4)->where('status', "<", 10)->where ("playerTwo",Auth::user()->id)
        ->orWhere('status', 999)->where ("playerTwo",Auth::user()->id)->get ())>0

          || count(Match:: where("status", ">", 4)->where('status', "<", 10)->where ("playerOne",Auth::user()->id)
          ->orWhere('status', 999)->where ("playerOne",Auth::user()->id)->get ())>0);
    }
    public static function fetch_num_of_msgs($id){
        return count(Msg::where('match_id', $id)->get());
    }
    public function firstPlayer(){
        return $this->hasOne('App\User', 'id', 'playerOne');
    }
    public function secondPlayer(){
        return $this->hasOne('App\User', 'id', 'playerOne');
    }
    public static function which_player_are_they($match, $user_id){
        if ($match->playerOne==$user_id){
          return 1;
        } else if ($match->playerTwo==$user_id){
          return 2;
        } else {
          return false;
        }
    }
    public static function whos_other_player($match, $user_id){
        if ($match->playerOne==$user_id){
          return $match->playerTwo;
        } else if ($match->playerTwo==$user_id){
          return $match->playerOne;
        } else {
          return false;
        }
    }
}
