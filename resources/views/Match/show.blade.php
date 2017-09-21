
<?php
    use App\Match;
    $point_caption = $match->wager>1 || $match->wager==0 ? "points" : "point";

?>


@extends('layouts.app')

@section('content')
<input id="matchID" type='hidden' value="{{$match->id}}" />
<input id="matchStatus" type='hidden' value="{{$match->status==999 ? 'null' : $match->status}}" />
<input id="numOfMsgs" type='hidden'  value='{{Match::fetch_num_of_msgs($match->id)}}' />

<div id='matchMenu' class='clearfix'>
    @include ("Match.menu")
</div>

<div class='text-center form-group'>
  <h3 title="    You've wagered {{$match->wager}} {{$point_caption}}. @if ($match->wager==0) Don't worry! You'll still win a point if you win!@endif">Wager: {{$match->wager}} {{$point_caption}}</h3>

</div>
<div id="" class='container'>
    <div id="matchMsgs">
        @include ('Msg.index')
    </div>


@if ($match->status==999 || ($match->status>4 && $match->status<10))
    @include ('Match.Msg.create', ['match_id'=>$match->id])
@else
    <h2 class='text-center'>{{Match::display_status_msg($match->id)}}</h1>
@endif


</div>
<div id='matchStatusMsg'>
    @include ('Match.statusMsg')
</div>

@endsection
