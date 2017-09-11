<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::guest()){
        return view('welcome');
    }
        return redirect (route('home'));
});
Route::get("/inventory/emoji/create/{slot}", 'InventoryController@create_emoji' )->name('inventory.create-emoji');
Route::get("inventory/empty", 'InventoryController@empty')->name('inventory.empty');
Route::get('match/{id}/quit', 'MatchController@quit')->name('match.quit');
Route::get('match/{id}/cancel-quit', 'MatchController@cancel_quit')->name('match.cancel-quit');
Route::get('match{id}/friend', 'MatchController@friend')->name('match.friend');
Auth::routes();

Route::get('/searching/{wager}', 'MsgController@searching');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/message', 'MsgController');
Route::resource('/match', 'MatchController');
Route::resource('/emoji', 'EmojiController');
Route::resource('/inventory', 'InventoryController');
