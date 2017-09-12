<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Match;
use App\Msg;

use Illuminate\Http\Request;

class MsgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this ->validate($request, [
        "matchID" => "required | integer",
        "msgInput"=>"required"
      ]);
      //validate if message contains the appropriate characters

      $message = new Msg;
      $message->body = $request->msgInput;
      $message->match_id = $request->matchID;
      $message->room_id = 0;

      $message->user_id = Auth::user()->id;
      $message->save ();
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function searching($wager){
      //move this to match controller
	    if (Auth::guest()){
            return View('User/need-to-be-logged-in');
	    }
        if ($wager>Auth::user()->points){
            return View('User/not-enough-points');
        }
        //going to need to check every minute and if user hasn't accessed site, change state back
        if(Auth::user()->state==0){
	        $user = User::find(Auth::user()->id);
	        $user->state=1;
            $user->save();
        } else if (Auth::user()->state==1){
            if (time()- strtotime(Auth::user()->updated_at) > 60){
	            $user = User::find(Auth::user()->id);
	            $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
            }
        } else if (Auth::user()->state==2){
            //TO DO create a field to show when player 2 enters and have them enter the first chat room they haven't entered
            $user = User::find(Auth::user()->id);
            $user->state=0;
            $user->save();
            return redirect(route("match.show", ['id'=>$match_id]));

        }
        $matched_user = User::where('id', '!=', Auth::user()->id)->where('state', TRUE)->inRandomOrder()->first();


        if (!empty($matched_user)){
          //there's a bug where the other player isn't being forwarded because they're treating ti like there already matched - maybe create a field to indicate that the player has entered the match
              //->where ("created_at", "<", date("Y-m-d H:i:s", strtotime("-1 min")))
          $are_they_already_matched =
            count(Match:: whereNull('status')
              ->where ("playerOne",$matched_user->id)->where("playerTwo", Auth::user()->id)->get ())>0
            || count(Match:: whereNull('status')
              ->where ("playerOne",Auth::user()->id)->where("playerTwo", $matched_user->id)->get ())>0;


          if (!$are_they_already_matched){

              $matched_user->state=2;
              $matched_user->save();
  	          $user = User::find(Auth::user()->id);
  	          $user->state=0;
              $user->save();
              $match = new Match;
              $match->playerOne = Auth::user()->id;
              $match->playerTwo = $matched_user->id;
              $match->wager = $wager;
              $match->save();
              return redirect()->action('MatchController@show', ['id'=>$match->id]);
          }
        }


	    return View('User/searching', ['matched_user'=>$matched_user, 'wager'=>$wager]);



    }

}
