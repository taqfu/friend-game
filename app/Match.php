<?php

namespace App;

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
}
