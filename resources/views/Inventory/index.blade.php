
@extends('layouts.app')

@section('content')
<h1 class='text-center'>Inventory</h1>
<a href="{{route('home')}}">Home</a>
<h2>Your Emojis</h2>
<div id="#emojiList" >
    @foreach ($emojis_in_inventory as $emoji_in_inventory)

        <div class='col-m-2'>
            <div >Slot #{{$emoji_in_inventory->emoji_slot}}</div>
            <?php
              $button_caption= ($emoji_in_inventory->emoji_id == 0 || $emoji_in_inventory->emoji_id == NULL)
                ? "Please click here to add an emoji to your inventory" : "&#x1f".$emoji_in_inventory->emoji->unicode;
            ?>
            <form action="{{route('inventory.create-emoji', ['slot'=>$emoji_in_inventory->emoji_slot])}}">
              <input type= "submit" value="{!!$button_caption!!}"/>
            </form>

        </div>

    @endforeach
  </div>
@endsection
