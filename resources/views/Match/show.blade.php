
@extends('layouts.app')

@section('content')

@foreach ($messages as $message)

    <div class='panel panel-default'>
      <div class=' panel-body'>
        @if ($message->user_id == Auth::user()->id)
            <span class='text-success'><strong>You:</strong></span>
        @else
            <span class='text-info'><strong>Them:</strong></span>
        @endif
        <span class='text-muted'>{{$message->body}}</span>
    </div>
    </div>
@endforeach
<div class='text-danger'>
@foreach ($errors->all() as $error)
  {{$error}}
@endforeach
</div>
@include ('Msg.create', ['match_id'=>$match->id])
@endsection
