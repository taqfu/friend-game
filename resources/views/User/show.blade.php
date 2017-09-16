@extends ('layouts.app')

@section('content')
<div class='clearfix form-group'>
    <form method="GET" action="{{route('home')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Home" />
    </form>
</div>
    <div class='container'>

        <h1 class='text-center'>{{$user->username}}</h1>
        <h3 class='form-group'> {{$user->points}} points / {{$user->emoji_slots}} slots - You became friends after
          <a href="{{route('match.show', ['id'=>$friendship->match_id])}}">Match #{{$friendship->match_id}}</a>.</h3>
        @forelse ($messages as $message)
            <div class='well'><{{date("m/d/y h:i:s", strtotime($message->created_at))}}> {{$message->body}}</div>
        @empty
            <h4 class='text-center'><i>This user hasn't said anything yet.</i></h4>
        @endforelse
    </div>
@endsection
