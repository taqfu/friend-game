<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function emoji(){
      return $this->hasOne("App\Emoji", "id", "emoji_id");
    }
    public static function add_emoji_slot($user_id){
        $last_inventory = Inventory::where('user_id', $user_id)->orderBy('emoji_slot', 'desc')->first();
        $inventory = new Inventory;
        $inventory->user_id = $user_id;
        $inventory->emoji_slot = $last_inventory->emoji_slot+1;
        $inventory->save();
    }
    public static function is_this_a_duplicate($emoji_id){
        return (count(Inventory::where('user_id', Auth::user()->id)->where('emoji_id', $emoji_id)->get())>1);
    }
}
