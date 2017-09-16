<?php
    use \App\Inventory;
    use \App\Match;
?>
@extends('layouts.app')

@section('content')
@include('menu')

<h1 class='text-center'>Inventory</h1>

<h2>Your Emojis</h2>
<div id="#emojiList" >
    @foreach ($emojis_in_inventory as $emoji_in_inventory)

        <div class='col-m-2'>
            <div >Slot #{{$emoji_in_inventory->emoji_slot}}</div>
            <?php
              $button_caption= ($emoji_in_inventory->emoji_id == 0 || $emoji_in_inventory->emoji_id == NULL)
                ? "Please click here to add an emoji to your inventory" : "&#x1f".$emoji_in_inventory->emoji->unicode;
            ?>
            @if (Match::does_user_have_active_match())
                {!!$button_caption!!} - Locked due to an active match
            @else
            <form action="{{route('inventory.create-emoji', ['slot'=>$emoji_in_inventory->emoji_slot])}}">
              <input type= "submit" value="{!!$button_caption!!}"/>
              @if ($emoji_in_inventory->emoji_id!=null && Inventory::is_this_a_duplicate($emoji_in_inventory->emoji_id))
                  <span class='text-danger'>Duplicate!</span>
              @endif
            </form>
            @endif

        </div>

    @endforeach
  </div>
@endsection
