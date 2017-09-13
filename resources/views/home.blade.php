<?php
$past_match_num=1;
$match_num=1;
?>
@extends('layouts.app')

@section('content')
@if (count($matches)>0)
<h3>Active Matches:</h3>
@endif
@foreach($matches as $match)
  <div><a href= "{{route('match.show', ['id'=>$match ->id])}}" >Match #{{$match_num}}</a> - started on {{date ("m/d/Y H:i:s", strtotime ($match ->created_at))}}</div>
  <?php $match_num++?>

@endforeach
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

@if (count($past_matches)>0)
<h3>
  Past Matches:
</h3>
@endif

@foreach($past_matches as $past_match)
  <div><a href= "{{route('match.show', ['id'=>$past_match->id])}}" >Match #{{$match_num}}</a> - started on {{date ("m/d/Y H:i:s", strtotime ($past_match->created_at))}}</div>
  <?php $past_match_num++?>

@endforeach

@endsection
