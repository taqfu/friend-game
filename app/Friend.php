<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public static function fetch_num_of_friends(){
        return count(Friend::where('a', Auth::user()->id)->get());
    }
}
