<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('home', 'HomeController@index');
// Route::get('/', 'HomeController@logout');
Route::post('home', 'HomeController@workplace');

Route::get('home/{id}/dovetails',['as' => 'dovetail', 'uses' => 'HomeController@dovetail']);


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Route::group(['prefix' => 'api'], function()
// {

//     Route::get('apartments', 'HomeController@apartments');

// });