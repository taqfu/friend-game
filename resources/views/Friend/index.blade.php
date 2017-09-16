@extends ('layouts.app')

@section('content')
@include('menu')

  <div class='container'>
    <h1 class='text-center'> Friends</h1>
    @forelse($friends as $friend)
      <a href="{{route('user.show', ['username'=>$friend->user->username])}}">{{$friend->user->username}}</a> - {{$friend->user->points}} points / {{$friend->user->emoji_slots}} slots
    @empty
        <h3> Sorry, you haven't made any friends yet. Play some matches and get more friends and more emoji slots. Good luck!</h3>
    @endforelse
  </div>
@endsection
