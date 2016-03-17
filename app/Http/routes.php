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

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    /*
    *
    * Application
    *
    */

    Route::get('/', array('as' => 'home', 'uses' =>'AppliController@index'));

	Route::get('/game/{type}', array('as' => 'categories', 'uses' =>'AppliController@categories'));

	Route::group(['middleware' => 'auth'], function (){
		Route::get('/game/{type}/{category}', array('as' => 'game', 'uses' =>'AppliController@game'));
	});

	/*
	*
	* Administration
	*
	*/

	Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function (){
		Route::get('/', array('as' => 'admin_home', 'uses' => 'AppliController@index'));

		Route::resource('category', 'CategoryController');
	});
});
