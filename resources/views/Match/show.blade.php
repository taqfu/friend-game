
@extends('layouts.app')

@section('content')
<div class='emoji'>
<?php
//echo "&U+1F600";

$bad_unicodes = [ "91f", "93f", "946", "928", "929", "92a", "92b", "92c", "92d", "92d", "92e", "92f", "931", "932", "94c", "94d", "94e", "94f" ];
$emoji=0;
for ($i=30;$i<95;$i++){
    for ($h=1;$h<16;$h++){
      if ($h>9){
        $hex = ["a", "b", "c", "d", "e", "f"];
        $unicode_ref = $i . $hex[$h-10];
      } else {
          $unicode_ref = $i . $h;

      }


      //var_dump ( $unicode_ref, $i, $h, "<BR>");
      if (($i<70 || $i>90) && !in_array($unicode_ref, $bad_unicodes)){ //&& ($unicode_ref<92 || $unicode_ref>932)  ){

      echo "<span title='$unicode_ref - $i - $h'> &#x1f" . $unicode_ref . "</span> ";
      $emoji++;
      }

  }

}
var_dump($emoji);
?>
</div>
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
