<?php
    use \App\Match;
    $player_num = Match::which_player_are_they($match, Auth::user()->id);
    $point_caption = $match->wager>1 || $match->wager==0 ? "points" : "point";
    if ($match->status==8 || $match->status==9){
        $quit_button_caption = ($player_num+7==$match->status) ? "Surrender" : "Accept Surrender";
    } else {
        $quit_button_caption =  "Offer withdrawl.";
    }
    $friend_button_caption = (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ? "Accept Friend Request" : "+Friend";
    $cancel_friend_button_caption = (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ? "Reject Friend Request" : "Cancel Friend Request";

?>


@extends('layouts.app')

@section('content')


<div class='clearfix'>

  <form method="GET" action="{{route('home')}}" class="form-inline">
      <input type='submit' class='btn btn-primary btn-lg pull-left' value="Home" />
  </form>
@if ($match->status==null || (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5)) ||  (($match->status ==8 || $match->status ==9) && $match->status!=$player_num+7))
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

</div>

<div class='text-center form-group'>
  <h3 title="    You've wagered {{$match->wager}} {{$point_caption}}. @if ($match->wager==0) Don't worry! You'll still win a point if you win!@endif">Wager: {{$match->wager}} {{$point_caption}}</h3>

</div>
<div class='container'>
@forelse ($messages as $message)
        @if ($message->user_id == Auth::user()->id)
        <div class="well">
            <span class='text-success'><strong>You:</strong></span><span class='text-muted'>{{$message->body}}</span>
        </div>

        @else
        <div class='panel panel-default'>
            <div class=' panel-body'>
                <span class='text-info'><strong>Them:</strong></span><span class='text-muted'>{{$message->body}}</span>
            </div>
        </div>
        @endif

@empty
    @if ($match->status > 4 && $match->status<10)
        <div class='text-center'>
            <i>Neither of you have said anything. Say something! Make a friend!</i>
        </div>
    @endif
@endforelse
<div class='text-danger'>
@foreach ($errors->all() as $error)
  {{$error}}
@endforeach
</div>
@if ($match->status==null || ($match->status>4 && $match->status<10))
@include ('Msg.create', ['match_id'=>$match->id])
@else
    <h2 class='text-center'>This is the win or lose message.</h1>
@endif


</div>
@if (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5))
    <h3 class='text-center clearfix'>They want to make friends! Accept and get more emojis to use! Refuse and win your wager.</h3>
@elseif (($match->status ==8 || $match->status ==9) && $match->status!=$player_num+7)
    <h3 class='text-center clearfix'>They want to quit. Quit with them and no one loses any points.</h3>
    <h3 class='text-center clearfix'>Or wait til they leave on their own and win, ya big meanie.</h3>

@endif
@endsection
