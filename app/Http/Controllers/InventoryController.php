<?php

namespace App\Http\Controllers;
use Auth;
use App\Emoji;

use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function empty(){
      if (Auth::guest()){
            return view("need-to-be-logged-in");
      }
      $num_of_emojis_in_inventory = count(Inventory::where('user_id', Auth::user()->id)->where('emoji_slot', '>', 0)->get());
      if ($num_of_emojis_in_inventory >= Auth::user()->emoji_slots){
        trigger_error("User #" . Auth:: user ()->id . " is attempting to setup inventory but inventory is already setup.");
      } else if ($num_of_emojis_in_inventory != 0){
        trigger_error("User #" . Auth:: user ()->id . " already has emoji's in their inventory but not enough..");
      }
      for ($slot_num=1; $slot_num <= Auth::user()->emoji_slots; $slot_num++){
          $inventory = new Inventory;
          $inventory->emoji_slot = $slot_num;
          $inventory->user_id = Auth::user()->id;
          $inventory->save();
      }
      return redirect(route("inventory.index"));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::guest()){
            return View('User/need-to-be-logged-in');
      }
      return view("Inventory.index", [
        "emojis_in_inventory"=>Inventory::where("user_id", Auth:: user ()->id)->where("emoji_slot", ">", 0)->orderBy("emoji_slot", "asc")->get (),

      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(){


     }
    public function create_emoji($slot)
    {
        return view("Inventory.create", [
          "emojis"=>Emoji::get (),
          "emoji_slot"=>$slot,
        ]);
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
      if ($request->emojiSlot>Auth::user()->emoji_slots){
        trigger_error("User #" . Auth:: user ()->id . " is attempting to create an emoji for slot #". $request->emojiSlot .". He only has " . Auth::user()->emoji_slots . "slots.");
      }
        $inventory = Inventory::where('emoji_slot', $request->emojiSlot)->where('user_id', Auth:: user ()->id)->first();
        $inventory->emoji_id =$request->emojiID;
        $inventory->save();
        return redirect(route("inventory.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
