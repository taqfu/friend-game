@extends('layouts.app')

@section('content')
@include('menu')
    @forelse ($messages as $message)
        <div title="{{date('m/d/y g:i:s e', strtotime($message->created_at))}}" class='well'><a href="{{route('user.show', ['username'=>$message->user->username])}}">{{$message->user->username}}</a>:<span class='text-default'><i>{{$message->body}}</i></span></div>
    @empty
    <h5 class='text-center'><i>
        No one's said anything yet. Say something and start a conversation.<br><br>
        @if ($num_of_friends==0)
            You don't have any friends. Play some matches and make some friends so you can see your friend's messages here.
        @endif
      </i></h5>
    @endforelse
    @include ("Msg.create")
@endsection
