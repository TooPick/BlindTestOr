<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' =>'AppliController@index'));

Route::get('/login', array('as' => 'login', 'uses' =>'AppliController@login'));

Route::get('/game/{type}', array('as' => 'categories', 'uses' =>'AppliController@categories'));

Route::get('/game/{type}/{category}', array('as' => 'game', 'uses' =>'AppliController@game'));

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
