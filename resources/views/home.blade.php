@extends('layouts.app')

@section('content')
@include('menu')
    @forelse ($messages as $message)

    @empty
    <h5 class='text-center'><i>
        No one's said anything yet. Say something and start a conversation.
        @if ($num_of_friends==0)
            You don't have any friends here. Play some matches and make some friends so you can see your friends' messages here.
        @endif
      </i></h5>
    @endforelse
@endsection
