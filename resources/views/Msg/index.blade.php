@forelse ($messages as $message)
        @if ($message->user_id == Auth::user()->id)
        <div class="well">
            <span class='text-success'><strong>You:</strong></span><span class='text-muted'>{{$message->body}}</span>
        </div>

        @else
        <div class='panel panel-default'>
            <div class=' panel-body'>
                <span class='text-info'><strong>Them:</strong></span><span class='text-muted'>{{$message->body}}</span>
            </div>
        </div>
        @endif

@empty
    @if ($match->status > 4 && $match->status<10)
        <div class='text-center'>
            <i>Neither of you have said anything. Say something! Make a friend!</i>
        </div>
    @endif
@endforelse
<div id="matchNewMsgs">

</div>
