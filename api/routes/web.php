<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DisplayMapController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\ValuelistController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\EiaPermitController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HearingController;
use App\Http\Controllers\ExternalAuditController;
use App\Http\Controllers\ExternalAuditDocumentController;
use App\Http\Controllers\AuditInspectionController;
use App\Http\Controllers\PermitLicenseController;
use App\Http\Controllers\EmailOrderController;
use App\Http\Controllers\ProjectSearchController;
use App\Http\Controllers\AuditInspectionSearchController;
use App\Http\Controllers\EiaPermitSearchController;
use App\Http\Controllers\PermitLicenseSearchController;
use App\Http\Controllers\ExternalAuditSearchController;
use App\Http\Controllers\ProjectStatisticsController;
use App\Http\Controllers\GeneralStatisticsController;
use App\Http\Controllers\Edit\CodeController;
use App\Http\Controllers\Edit\UserController as EditUserController;
use App\Http\Controllers\Edit\EmailOrderController as EditEmailOrderController;
use App\Http\Controllers\Edit\LeadAgencyController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PirkingController;
use App\Http\Controllers\DataAnonymizerController;
use App\Http\Controllers\Export\ExportMapController;

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

// Route::get('password/reset/{token}', function($token){
//     dd("got here", $token);
//     return redirect(url(env('CLIENT_RESET_LINK').$token));
// });

Route::get('/', function ()
{
    return redirect(env('CLIENT'));
});

Route::get('/cron-route', function ()
{
    return abort(404, 'issue getting displace size');
    Artisan::call("email:process");
    try {
        if((float)disk_free_space(".") < 1090000000) {
            return abort('issue getting displace size');
        }
    } catch(\exception $e) {
        abort('issue getting displace size');
    }
    return Artisan::output();
});

Route::get('/env', function(){
    return ['env' => config('app.setup'), 'lv_version' => app()->version()];
});

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('info', function ()
    {
        phpinfo();
    });
    Route::get('plot-projects', [DisplayMapController::class, 'plotProjects']);
});

Auth::routes();
Route::post('auth/login', [LoginController::class, 'login']);
Route::get('auth/logout', [LoginController::class, 'logout']);

Route::prefix('user')->middleware('auth')->group(function ()
{
    Route::get('info', [UserController::class, 'getInfo']);
    if (App::environment() !== "production")
    {
        Route::get('impersonate/{id}', [UserController::class, 'impersonate']);
    }
    Route::get('all', [UserController::class, 'getAll']);
});

Route::prefix('api/v1')->group(function ()
{
    Route::resource('practitioner', PractitionerController::class);
    Route::resource('valuelist', ValuelistController::class);
});

Route::prefix('api/v1')->middleware('auth')->group(function ()
{
    // Route::resource('practitioner', 'PractitionerController');
    Route::resource('project', ProjectController::class);
    Route::get('organisation/{offset}/{search}',[OrganisationController::class, 'index']);
    Route::resource('organisation', OrganisationController::class);
    Route::resource('project.eiapermit', EiaPermitController::class);
    Route::resource('project.eiapermit.document', DocumentController::class);
    Route::resource('project.eiapermit.document.hearing', HearingController::class);

    Route::resource('project.externalaudit', ExternalAuditController::class);
    Route::resource('project.externalaudit.document', ExternalAuditDocumentController::class);

    Route::resource('project.auditinspection', AuditInspectionController::class);

    Route::resource('project.permitlicense', PermitLicenseController::class);
    Route::get('create-email-order/{orderType}/{entityId}/{documentId}',[EmailOrderController::class, 'orderRequest']);
});

Route::get('/resolveLink/emailOrder/{orderType}/{identifier}',[EmailOrderController::class, 'resolveDocumentLink']);

Route::prefix('search/v1')->middleware('auth')->group(function ()
{
    Route::resource('project', ProjectSearchController::class);
    Route::resource('auditinspection', AuditInspectionSearchController::class);
    Route::resource('eiapermit', EiaPermitSearchController::class);
    Route::resource('permitlicense', PermitLicenseSearchController::class);
    Route::resource('externalaudit', ExternalAuditSearchController::class);
});

Route::prefix('statistics/v1')->middleware('auth')->group(function ()
{
    Route::resource('project', ProjectStatisticsController::class);
    Route::resource('general', GeneralStatisticsController::class);
});

Route::prefix('edit/v1')->middleware('manager')->group(function ()
{
    Route::resource('code', CodeController::class);
    Route::resource('user', EditUserController::class);
    Route::resource('emailOrder', EditEmailOrderController::class);
    Route::resource('leadagency', LeadAgencyController::class);
});


Route::prefix('file/v1')->middleware('auth')->group(function ()
{
    Route::post('upload', [FileController::class, 'upload']);
    Route::get('download/{id}', [FileController::class, 'download']);
    Route::get('delete/{id}', [FileController::class, 'delete']);
});

Route::prefix('pirking/v1')->middleware('manager')->group(function ()
{
    Route::get('eiaspermits', [PirkingController::class, 'getEiasPermits']);
    Route::get('eiaspermits/stats', [PirkingController::class, 'getEiasPermitsStats']);

    Route::get('externalAuditList', [PirkingController::class, 'getExternalAudit']);
    Route::get('externalAuditList/stats', [PirkingController::class, 'getExternalAuditStats']);

    Route::get('auditInspection', [PirkingController::class, 'getAuditInspection']);
    Route::get('auditInspection/stats', [PirkingController::class, 'getAuditInspectionStats']);

    Route::get('permitLicense', [PirkingController::class, 'getPermitLicense']);
    Route::get('permitLicense/stats', [PirkingController::class, 'getPermitLicenseStats']);
});

Route::prefix('export/v1')->group(function ()
{
    Route::get('445101cc8de29ef4dca8c78cefa15d3ee7b66c4b/maps', [ExportMapController::class, 'exportMap']);
});

Route::get('anonymizerData/v1/{action}', [DataAnonymizerController::class, 'index']);


