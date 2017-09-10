<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function emoji(){
      return $this->hasOne("App\Emoji", "id", "emoji_id");
    }
}
