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
Route::get('match/{id}/msg/new/{num_of_old_msgs}', 'MatchController@new_msgs')->name('match.new-msgs');
Route::get('match/{id}/menu', 'MatchController@menu')->name('match.menu');
Route::get('match/{id}/status', 'MatchController@status')->name('match.status');
Route::get('match/{id}/statusMsg', 'MatchController@status_msg');
Route::get('match/{id}/quit', 'MatchController@quit')->name('match.quit');
Route::get('match/{id}/cancel-quit', 'MatchController@cancel_quit')->name('match.cancel-quit');
Route::get('match/{id}/friend', 'MatchController@friend')->name('match.friend');
Route::get('match/{id}/cancel-friend', 'MatchController@cancel_friend')->name('match.cancel-friend');
Auth::routes();

Route::get('/searching/{wager}', 'MatchController@searching');
Route::get('/home', 'HomeController@index')->name('home');



Route::resource('/emoji', 'EmojiController');
Route::resource('/friend', 'FriendController');
Route::resource('/inventory', 'InventoryController');
Route::resource('/match', 'MatchController');
Route::resource('/message', 'MsgController');
Route::resource('/user', 'UserController');
