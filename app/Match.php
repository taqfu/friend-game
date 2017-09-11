<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public function firstPlayer(){
        return $this->hasOne('App\User', 'id', 'playerOne');
    }
    public function secondPlayer(){
        return $this->hasOne('App\User', 'id', 'playerOne');
    }
    public static function which_player_are_they($match, $user_id){
      var_dump($match->playerTwo, $user_id);
        if ($match->playerOne==$user_id){
          return 1;
        } else if ($match->playerTwo==$user_id){
          return 2;
        } else {
          return false;
        }
    }
}
