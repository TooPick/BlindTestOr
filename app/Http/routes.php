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
		Route::get('/profil', array('as' => 'profil' , 'uses' => 'AppliController@profil'));

		Route::post('/profil', array('as' => 'profil.post' , 'uses' => 'AppliController@profilPost'));
		Route::post('/contact', array('as' => 'contact' , 'uses' => 'AppliController@contact'));

		//Routes du jeu (ajax)
		Route::group(['namespace' => 'Game', 'prefix' => 'game'], function () {
			Route::post('/ajax/sendMessage', array('as' => 'ajax.sendMessage', 'uses' => 'GameController@ajaxSendMessage'));
			Route::post('/ajax/autoUpdate', array('as' => 'ajax.autoUpdate', 'uses' => 'GameController@ajaxAutoUpdate'));
			Route::post('/ajax/exitGame', array('as' => 'ajax.exitGame', 'uses' => 'GameController@ajaxExitGame'));
			Route::post('/ajax/getPlaylist', array('as' => 'ajax.getPlaylist', 'uses' => 'GameController@ajaxGetPlaylist'));
			Route::post('/ajax/addAction', array('as' => 'ajax.addAction', 'uses' => 'GameController@ajaxAddAction'));
			Route::post('/ajax/setSong', array('as' => 'ajax.setSong', 'uses' => 'GameController@ajaxSetSong'));
			Route::post('/ajax/endRound', array('as' => 'ajax.endRound', 'uses' => 'GameController@ajaxEndRound'));
			Route::post('/ajax/getScores', array('as' => 'ajax.getScores', 'uses' => 'GameController@ajaxGetScores'));
		});
	});


	/*
	*
	* Administration
	*
	*/

	Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function (){
		Route::get('/', array('as' => 'admin_home', 'uses' => 'AppliController@index'));

		Route::resource('category', 'CategoryController');
		Route::resource('song', 'SongController');
		Route::resource('user', 'UserController');
	});
});
