<div class='text-danger'>
@foreach ($errors->all() as $error)
  {{$error}}
@endforeach
</div>
<form method="POST" action="{{route('message.store')}}">
    {{csrf_field()}}
        <input type='hidden' name='matchID' value='0' />

    <div class='form-group'>
    </div>
    <div class='form-group'>
        @foreach ($inventory_emojis as $inventory_emoji)
          <input type='button' value='&#x1f{{$inventory_emoji->emoji->unicode}}' class='btn btn-lg msgKeys' />

        @endforeach
    </div>
    <div class='form-group'>
        <input type='text' name='msgInput' id='msgInput' class='form-control' />
        <input type='submit' class='btn btn-primary btn-lg pull-right' value='Send'/>
    </div>
    <script>
    </script>

</form>
