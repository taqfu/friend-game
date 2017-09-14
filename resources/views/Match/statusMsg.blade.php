<?php
    use App\Match;
    $player_num = Match::which_player_are_they($match, Auth::user()->id);
?>

@if (($player_num==1 && $match->status==6) || ($player_num==2 && $match->status==5))
    <h3 class='text-center clearfix'>They want to make friends! Accept and get more emojis to use! Refuse and win your wager.</h3>
@elseif (($match->status ==8 || $match->status ==9) && $match->status!=$player_num+7)
    <h3 class='text-center clearfix'>They want to quit. Quit with them and no one loses any points.</h3>
    <h3 class='text-center clearfix'>Or wait til they leave on their own and win, ya big meanie.</h3>
@endif
