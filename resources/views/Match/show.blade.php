<?php use \App\Match; ?>
<?php $point_caption = $match->wager>1 || $match->wager==0 ? "points" : "point"; ?>

@extends('layouts.app')

@section('content')
<?php $button_caption =  ($match->status==8 || $match->status==9) ? "Surrender" : "Offer withdrawl."; ?>

<div class='clearfix'>

  <form method="GET" action="{{route('home')}}" class="form-inline">
      <input type='submit' class='btn btn-primary btn-lg pull-left' value="Home" />
  </form>
  <form method="GET" action="{{route('match.friend', ['id'=>$match->id])}}" class="form-inline">
      <input type='submit' class='btn btn-primary btn-lg pull-left' value="+Friend" />
  </form>

  <form method="GET" action="{{route('match.quit', ['id'=>$match->id])}}" class="form-inline">
    <input type='submit' class='btn btn-danger btn-lg pull-right' value="{{$button_caption}}" />
</form>
@if ($match->status!=null && Match::which_player_are_they($match, Auth::user()->id)+7==$match->status)
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
<div class='text-center'>
    <i>Neither of you have said anything. Say something! Make a friend!</i>
  </div>
@endforelse
<div class='text-danger'>
@foreach ($errors->all() as $error)
  {{$error}}
@endforeach
</div>
@include ('Msg.create', ['match_id'=>$match->id])
</div>
@endsection
