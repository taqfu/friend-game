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
        "matchID"=>"required | integer",
        "msgInput"=>"required"
      ]);

      if (Auth::guest()){
            return View('User/need-to-be-logged-in');
      }
      if ($request->matchID!=0){
          $match = Match::find($request->matchID);

          if (count($match)==0){
              trigger_error("There is no match of the ID #" . $request->match_id);
          }
          if (Auth::user()->id != $match->playerOne && Auth::user()->id != $match->playerTwo){
              trigger_error("You are not involved in this match.");
          }
      }

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


}
