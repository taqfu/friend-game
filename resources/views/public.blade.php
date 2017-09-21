@extends ('layouts.app')

@section('content')
<h1 class='text-center'>Friend Game</h1>

<h3 class='text-center'>
Friend Game is a concept I came up with for <a href="https://itch.io/jam/weird-game-jam">Weird Game Jam</a>.
</h3>

<h3 class='text-center'>You're limited to just a few emojis. 4, initially. </h3>
<div class='text-center'><img src="inv.png" style='border:1px black solid;'></div>
<h3 class='text-center'> Using just those emojis you talk to a random person. </h3>
<div class='text-center'><img src="chat2.png" style='border:1px black solid;'></div>

<h3 class='container text-center'>If you think you two would get along, you offer a friend request. If they deny you, they get a point. If they agree, you become friends and you get an additional slot for another emoji. It's really simple. Now go make some friends!</h3>
<form method="GET" action="{{route("register")}}">
    <input type='submit' class='btn btn-large btn-primary btn-block' value='Sign Up Now' />
</form>
@endsection
