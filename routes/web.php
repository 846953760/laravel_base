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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Home\IndexController@index');

Route::prefix('home')->namespace('Home')->group(function(){
	Route::prefix('index')->group(function(){
		Route::get('create','IndexController@create');
		Route::get('show/{id}','IndexController@show');
		Route::get('update/{id}','IndexController@update');
		Route::get('destroy/{id}','IndexController@destroy');
		Route::get('store','IndexController@store');
	});
});
