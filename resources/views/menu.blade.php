<div class='clearfix form-group'>
    @if (Route::currentRouteName()!="home")
    <form method="GET" action="{{route('home')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Home" />
    </form>
    @endif

    @if (Route::currentRouteName()!="match.index")
    <form method="GET" action="{{route('match.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Matches" />
    </form>
    @endif
    @if (Route::currentRouteName()!="inventory.index")
    <form method="GET" action="{{route('inventory.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Inventory" />
    </form>
    @endif
    @if (Route::currentRouteName()!="friend.index")
    <form method="GET" action="{{route('friend.index')}}" class="form-inline">
        <input type='submit' class='btn btn-primary btn-lg pull-left' value="Friends" />
    </form>
    @endif
</div>
