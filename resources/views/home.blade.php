<?php $match_num=1 ?>
@extends('layouts.app')

@section('content')
@foreach($matches as $match)
  <div><a href= "{{route('match.show', ['id'=>$match ->id])}}" >Match #{{$match_num}}</a> - started on {{date ("m/d/Y H:i:s", strtotime ($match ->created_at))}}</div>
  <?php $match_num++?>

@endforeach
<a href="/searching/0">Match with someone</a> - still need to be point specific

@endsection
