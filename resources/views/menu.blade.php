<div class='clearfix form-group'>
    <form method="GET" action="{{route('home')}}" class="form-inline" >
        <input type='submit' class='btn btn-primary btn-lg pull-left  ' value="Home" />
    </form>


    <form method="GET" action="{{route('match.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Matches" />
    </form>
    <form method="GET" action="{{route('inventory.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Inventory" />
    </form>
    <form method="GET" action="{{route('friend.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Friends" />
    </form>
</div>
