
@extends('layouts.app')

@section('content')
<div class='text-center'>
    @foreach ($emojis as $emoji)
        <form method="POST" action="{{route('inventory.store')}}" style='display:inline;'>
        {{csrf_field()}}
        <input type='hidden' name="emojiSlot" value="{{$emoji_slot}}" />
        <input type='hidden' name='emojiID' value="{{$emoji->id}}" />
        <input type= "submit" value="&#x1f{{$emoji->unicode}}"/>

        </form>
    @endforeach
  </div>
@endsection
