<?php

namespace App\Http\Controllers;

use App\Emoji;
use Auth;
use Illuminate\Http\Request;

class EmojiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (Auth::guest()){
          return view("need-to-be-logged-in");
      }
      if (Auth::user()->id!=1){
          echo "Sorry. Only admins can do this.";
      }
        return view('Emoji/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guest()){
            return view("need-to-be-logged-in");
        }
        if (Auth::user()->id!=1){
            echo "Sorry. Only admins can do this.";
        }
        $num_of_emojis = $request->numberOfEmojis;
        for($emoji_num=1; $emoji_num<=$num_of_emojis;$emoji_num++){
          $unicode_ref = $request->{"unicode".$emoji_num};

          $check_emoji = Emoji::where('unicode', $unicode_ref)->first();
          var_dump($unicode_ref, $check_emoji, "<BR>");

          if ($check_emoji==null){
              $emoji = new Emoji;
              $emoji->unicode = $unicode_ref;
              $emoji->save();
          }          
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emoji  $emoji
     * @return \Illuminate\Http\Response
     */
    public function show(Emoji $emoji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emoji  $emoji
     * @return \Illuminate\Http\Response
     */
    public function edit(Emoji $emoji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emoji  $emoji
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emoji $emoji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emoji  $emoji
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emoji $emoji)
    {
        //
    }
}
