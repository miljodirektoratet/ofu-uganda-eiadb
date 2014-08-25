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

Route::get('/client', function()
{
	$clientUrl = $_ENV['app_url'].$_ENV['app_client'];
	return Redirect::to($clientUrl);
});

Route::group(array('prefix' => 'password'), function()
{
	Route::get('reset', array('as' => 'password.remind', 'uses' => 'PasswordController@getRemind'));
	Route::post('reset', array('as' => 'password.request', 'uses' => 'PasswordController@postRemind'));
	Route::get('reset/{token}', array('as' => 'password.reset', 'uses' => 'PasswordController@getReset'));
	Route::post('reset/{token}', array('as' => 'password.update', 'uses' => 'PasswordController@postReset'));
});

Route::group(array('prefix' => 'user', 'before' => 'auth.basic'), function()
{
	Route::get('info', array('uses' => 'UserController@getInfo'));
	if (App::environment() !== "production")
	{
		Route::get('impersonate/{id}', array('uses' => 'UserController@impersonate'));
	}
	Route::get('all', array('uses' => 'UserController@getAll'));
});
Route::get('signout', array('uses' => 'UserController@signout'));


Route::group(array('prefix' => 'v1', 'before' => 'auth.basic'), function()
{	
  Route::resource('practitioner', 'PractitionerController');
  Route::resource('valuelist', 'ValuelistController');  
  Route::resource('project', 'ProjectController');
  Route::resource('organisation', 'OrganisationController');
  Route::resource('project.eiapermit', 'EiaPermitController');
  Route::resource('project.eiapermit.document', 'DocumentController');
});