<?php

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

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/user_list', 'userController@userData');

Route::get('/buyGladiator/{id}','GladiatorController@buy');
Route::get('/buySlave/{id}','SlaveController@buy');


//Route::get('/gladiator', function () {




//    return redirect('gladiator');

//  });
//
//   Route::post('/gladiator', function () {
//
//
//
//
//     return redirect('gladiator/{name}');
//
//   });

Route::resource('gladiator', 'GladiatorController');
Route::resource('slave', 'SlaveController');

