<?php

use App\Http\Controllers\GladiatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;

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
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home', 'UserController@userImage');
    Route::get('/buyGladiator/{id}', 'GladiatorController@buy');
    Route::get('/buySlave/{id}', 'SlaveController@buy');
    Route::get('myGladiators', 'GladiatorController@gladiatorList')->name('myGladiators');
    Route::get('mySlaves', 'SlaveController@slaveList');
    Route::resource('gladiator','GladiatorController');
    Route::resource('slave', 'SlaveController');
    Route::get('gladiator/sell/{id}', 'GladiatorController@sell')->name('gladiator.sell');
    Route::get('slave/sell/{id}', 'SlaveController@sell')->name('slave.sell');
    Route::get('updatingIndicators', 'UserController@updatingIndicators')->name('user.updatingIndicators');
    Route::get('profile', 'UserController@show')->name('user.show');
    Route::post('profile', 'UserController@update')->name('user.update');
    Route::get('users', 'UserController@usersList')->name('user.userList');
    Route::post('/users', 'UserController@admRights')->name('user.admRights');
    Route::get('/', 'HomeController@description')->name('description');
    Route::post('/sendInvite', 'OrderController@ship')->name('ship');
    Route::get('/sendInvite', 'OrderController@show')->name('showShip');
    Route::post('/arena', 'GladiatorController@arena')->name('arena');
    Route::get('/arena', 'GladiatorController@arenaView')->name('arenaView');
    Route::get('/lastArena', 'GladiatorController@lastArena')->name('lastArena');
    Route::get('/cemetery', 'GladiatorController@cemeteryView')->name('cemeteryView');
    Route::get('/tech', 'OrderController@techView')->name('techView');
    Route::post('/tech', 'OrderController@tech')->name('tech');

});


