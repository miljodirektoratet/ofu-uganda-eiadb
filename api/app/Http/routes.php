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

/*Event::listen('illuminate.query', function($query)
{
  if (strpos($query, 'projects') !== FALSE)
    {
      dd($query);
    }
});*/

Route::get('/', function ()
{
    return redirect(env('CLIENT'));
});

Route::get('/env', function(){
    return ['env'=>env('APP_SETUP')];
});

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('info', function ()
    {
        phpinfo();
    });
    Route::get('plot-projects', ['uses' => 'DisplayMapController@plotProjects']);
});


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::group(['prefix' => 'user', 'middleware' => 'auth'], function ()
{
    Route::get('info', ['uses' => 'UserController@getInfo']);
    if (App::environment() !== "production")
    {
        Route::get('impersonate/{id}', ['uses' => 'UserController@impersonate']);
    }
    Route::get('all', ['uses' => 'UserController@getAll']);
});

Route::group(['prefix' => 'api/v1'], function ()
{
    Route::resource('practitioner', 'PractitionerController');
    Route::resource('valuelist', 'ValuelistController');
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth'], function ()
{
    // Route::resource('practitioner', 'PractitionerController');
    Route::resource('project', 'ProjectController');
    Route::get('organisation/{offset}/{search}','OrganisationController@index');
    Route::resource('organisation', 'OrganisationController');
    Route::resource('project.eiapermit', 'EiaPermitController');
    Route::resource('project.eiapermit.document', 'DocumentController');
    Route::resource('project.eiapermit.document.hearing', 'HearingController');

    Route::resource('project.externalaudit', 'ExternalAuditController');
    Route::resource('project.externalaudit.document', 'ExternalAuditDocumentController');

    Route::resource('project.auditinspection', 'AuditInspectionController');

    Route::resource('project.permitlicense', 'PermitLicenseController');
});

Route::group(['prefix' => 'search/v1', 'middleware' => 'auth'], function ()
{
    Route::resource('project', 'ProjectSearchController');
    Route::resource('auditinspection', 'AuditInspectionSearchController');
    Route::resource('eiapermit', 'EiaPermitSearchController');
    Route::resource('permitlicense', 'PermitLicenseSearchController');
    Route::resource('externalaudit', 'ExternalAuditSearchController');
});

Route::group(['prefix' => 'statistics/v1', 'middleware' => 'auth'], function ()
{
    Route::resource('project', 'ProjectStatisticsController');
    Route::resource('general', 'GeneralStatisticsController');
});

Route::group(['prefix' => 'edit/v1', 'middleware' => 'manager'], function ()
{
    Route::resource('code', 'Edit\CodeController');
    Route::resource('user', 'Edit\UserController');
    Route::resource('leadagency', 'Edit\LeadAgencyController');
});


Route::group(['prefix' => 'file/v1', 'middleware' => 'auth'], function ()
{
    Route::post('upload', ['uses' => 'FileController@upload']);
    Route::get('download/{id}', ['uses' => 'FileController@download']);
    Route::get('delete/{id}', ['uses' => 'FileController@delete']);
});

Route::group(['prefix' => 'pirking/v1', 'middleware' => 'manager'], function ()
{
    Route::get('eiaspermits', ['uses' => 'PirkingController@getEiasPermits']);

    Route::get('externalAuditList', ['uses' => 'PirkingController@getExternalAudit']);

    Route::get('auditInspection', ['uses' => 'PirkingController@getAuditInspection']);

    Route::get('permitLicense', ['uses' => 'PirkingController@getPermitLicense']);
});

Route::group(['prefix' => 'export/v1'], function ()
{
    Route::get('445101cc8de29ef4dca8c78cefa15d3ee7b66c4b/maps', ['uses' => 'Export\ExportMapController@exportMap']);
});


