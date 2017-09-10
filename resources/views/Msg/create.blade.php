<form method="POST" action="{{route('message.store')}}">
    {{csrf_field()}}
    @if (isset($match_id))
        <input type='hidden' name='matchID' value='{{$match_id}}' />
    @endif
    <div class='form-group'>
    </div>
    <div class='form-group'>
        @foreach ($inventory_emojis as $inventory_emoji)
          <input type='button' value='&#x1f{{$inventory_emoji->emoji->unicode}}' class='btn btn-lg msgKeys' />

        @endforeach
        <input type='button' value='DEL' id='delKey' class='btn btn-danger btn-lg pull-right'/>
    </div>
    <div class='form-group'>
        <input type='text' name='msgInput' id='msgInput' class='form-control' readonly/>
        <input type='submit' class='btn btn-primary btn-block' value='Send'/>
    </div>
    <script>
    </script>

</form>
