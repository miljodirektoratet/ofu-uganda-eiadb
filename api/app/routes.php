<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Auth::logout();
//Auth::loginUsingId(1);

Route::get('/', function()
{	
	return View::make('hello');
});

Route::group(array('prefix' => 'password'), function()
{
	Route::get('reset', array('as' => 'password.remind',
	  'uses' => 'PasswordController@getRemind'));

	Route::post('reset', array('as' => 'password.request',
	  'uses' => 'PasswordController@postRemind'));

	Route::get('reset/{token}', array('as' => 'password.reset',
	  'uses' => 'PasswordController@getReset'));

	Route::post('reset/{token}', array('as' => 'password.update',
	  'uses' => 'PasswordController@postReset'));
});


Route::get('/user', array('as' => 'user.show',
	'before' => 'auth.basic',
	'uses' => 'UserController@getIndex'	
));


Route::group(array('prefix' => 'v1', 'before' => 'auth.basic'), function()
{	
    Route::resource('practitioner', 'PractitionerController');    
});