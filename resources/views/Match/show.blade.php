
@extends('layouts.app')

@section('content')

@foreach ($messages as $message)

@endforeach
@include ('Msg.create', ['match_id'=>$match->id])
@endsection
