<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Match;
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
      echo $request['MsgInput'];

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
        }
        $matched_user = User::where('id', '!=', Auth::user()->id)->where('state', TRUE)->inRandomOrder()->first();
        var_dump($matched_user->username);
        if (!empty($matched_user)){
            //$matched_user->state=0;
            $matched_user->save();
	        $user = User::find(Auth::user()->id);
	        //$user->state=0;
            $user->save();
            $match = new Match;
            $match->playerOne = Auth::user()->id;
            $match->playerTwo = $matched_user->id;
            $match->wager = $wager;
            $match->save();
            return redirect()->action('MatchController@show', ['id'=>$match->id]);
        }

	    return View('User/searching', ['matched_user'=>$matched_user, 'wager'=>$wager]);



    }

}
