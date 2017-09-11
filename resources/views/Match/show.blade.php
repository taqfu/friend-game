
@extends('layouts.app')

@section('content')
<?php $button_caption =  ($match->status==8 || $match->status==9) ? "Quit" : "Offer withdrawl."; ?>
<div class='clearfix'>

<form method="GET" action="{{route('match.quit', ['id'=>$match->id])}}" class="form-inline">
    <input type='submit' class='btn btn-danger btn-lg pull-right' value="{{$button_caption}}" />
</form>
  <a href="{{route('home')}}">Home</a>
</div>
<div class='container'>
@foreach ($messages as $message)


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


@endforeach
<div class='text-danger'>
@foreach ($errors->all() as $error)
  {{$error}}
@endforeach
</div>
@include ('Msg.create', ['match_id'=>$match->id])
</div>
@endsection
