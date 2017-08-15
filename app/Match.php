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
}
