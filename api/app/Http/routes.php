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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('info', function(){
  phpinfo();  


});

Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function()
{
  Route::get('info', ['uses' => 'UserController@getInfo']);
  if (App::environment() !== "production")
  {
    Route::get('impersonate/{id}', ['uses' => 'UserController@impersonate']);
  }
  Route::get('all', ['uses' => 'UserController@getAll']);
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth'], function()
{ 
  Route::resource('practitioner', 'PractitionerController');
  Route::resource('valuelist', 'ValuelistController');
  Route::resource('project', 'ProjectController');
  Route::resource('organisation', 'OrganisationController');
  Route::resource('project.eiapermit', 'EiaPermitController');
  Route::resource('project.eiapermit.document', 'DocumentController');
});
