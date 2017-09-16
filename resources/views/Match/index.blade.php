<?php
use \App\Match;
$past_match_num=1;
$match_num=1;
?>
@extends('layouts.app')

@section('content')
@include('menu')
<div class='container'>
    <h1 class='text-center form-group'>Matches</h1>
    <strong>Match With Someone & Make A Friend</strong> - Wager:
      <a href="/searching/0">0 pts.</a>
      |
      @if (Auth::user()->points>0)
          <a href="/searching/1">1 pts.</a>
      @else
          1 pts.
      @endif
      |
      @if (Auth::user()->points>9)
          <a href="/searching/10">10 pts.</a>
      @else
          10 pts.
      @endif
      |
      @if (Auth::user()->points>99)
          <a href="/searching/100">100 pts.</a>
      @else
          100 pts.
      @endif
      |

    @if (count($matches)>0)
    <h3>Active Matches:</h3>
    @endif
    @foreach($matches as $match)
        <a title="{{date ("m/d/Y H:i:s e", strtotime ($match->created_at))}} " href= "{{route('match.show', ['id'=>$match->id])}}"> #{{$match->id}} </a>
        - {{Match::display_status_msg($match->id)}}

    @endforeach


    @if (count($past_matches)>0)
    <h3>
      Past Matches:
    </h3>
    @endif

    @foreach($past_matches as $past_match)
      <div>
          <a title="{{date ("m/d/Y H:i:s e", strtotime ($past_match->created_at))}} " href= "{{route('match.show', ['id'=>$past_match->id])}}"> #{{$past_match->id}} </a>
           - {{Match::display_status_msg($past_match->id)}}
      </div>


    @endforeach
</div>
@endsection
