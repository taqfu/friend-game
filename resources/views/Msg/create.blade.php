<form method="POST" action="{{route('message.store')}}">
    {{csrf_field()}}
    @if (isset($match_id))
        <input type='hidden' name='matchID' value='{{$match_id}}' />
    @endif
    <div class='form-group'>
    </div>
    <div class='form-group'>
        <input type='button' value='A' class='btn btn-lg msgKeys' />
        <input type='button' value='B' class='btn btn-lg msgKeys' />
        <input type='button' value='C' class='btn btn-lg msgKeys'/>
        <input type='button' value='D' class='btn btn-lg msgKeys' />
        <input type='button' value='DEL' id='delKey' class='btn btn-danger btn-lg pull-right'/>
    </div>
    <div class='form-group'>
        <input type='text' name='msgInput' id='msgInput' class='form-control' readonly/>
        <input type='submit' class='btn btn-primary btn-block' value='Send'/>
    </div>
    <script>
    </script>

</form>
