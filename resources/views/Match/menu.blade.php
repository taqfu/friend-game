<?php
use \App\Match;
$player_num = Match::which_player_are_they($match, Auth::user()->id);

if ($match->status==8 || $match->status==9){
    $quit_button_caption = ($player_num+7==$match->status) ? "Surrender" : "Accept Surrender";
} else {
    $quit_button_caption =  "Offer withdrawl.";
}
$friend_button_caption = (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ? "Accept Friend Request" : "+Friend";
$cancel_friend_button_caption = (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ? "Reject Friend Request" : "Cancel Friend Request";

?>

<form method="GET" action="{{route('home')}}" class="form-inline">
    <input type='submit' class='btn btn-primary btn-lg pull-left' value="Home" />
</form>
@if ($match->status==999 || (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ||  (($match->status ==8 || $match->status ==9) && $match->status!=$player_num+7))
<form method="GET" action="{{route('match.friend', ['id'=>$match->id])}}" class="form-inline">
    <input type='submit' class='btn btn-primary btn-lg pull-left' value="{{$friend_button_caption}}" />
</form>
@endif
@if ($match->status == 5 || $match->status == 6)
<form method="GET" action="{{route('match.cancel-friend', ['id'=>$match->id])}}" class="form-inline">
    <input type='submit' class='btn btn-danger btn-lg pull-left' value="{{$cancel_friend_button_caption}}" />
</form>

@endif
@if ($match->status !=5 && $match->status !=6)
<form method="GET" action="{{route('match.quit', ['id'=>$match->id])}}" class="form-inline">
  <input type='submit' class='btn btn-danger btn-lg pull-right' value="{{$quit_button_caption}}" />
</form>
@endif
@if ($match->status!=null && $player_num+7==$match->status)
<form method="GET" action="{{route('match.cancel-quit', ['id'=>$match->id])}}" class="form-inline">
<input type='submit' class='btn btn-lg pull-right' value="Cancel" />
</form>
@endif
