<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailFromRegistration;

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

Route::get('/link/{slug}', [App\Http\Controllers\LinkController::class, 'show']);

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function(){
      return redirect('/login');
    });
    Route::get('/login-admin', [App\Http\Controllers\AuthAdminController::class, 'index']);
    Route::post('/login-admin', [App\Http\Controllers\AuthAdminController::class, 'login'])->name('login-admin');

    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register');

    // Route::get('/auth/{provider}', [App\Http\Controllers\SocialiteController::class, 'redirectToProvider']);
    // Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteController::class, 'handleProvideCallback']);
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [ App\Http\Controllers\DashboardController::class, 'index' ])
    ->middleware('permission:dashboard.index')->name('dashboard');

    Route::resource('/jobs', \App\Http\Controllers\JobController::class, [ 'except' => ['show'] ])
    ->middleware('permission:master.jobs.index|master.jobs.create|master.jobs.edit|master.jobs.delete');

    Route::resource('/shifts', \App\Http\Controllers\ShiftController::class, [ 'except' => ['show'] ])
    ->middleware('permission:master.shifts.index|master.shifts.create|master.shifts.edit|master.shifts.delete');

    Route::resource('/manufactures', \App\Http\Controllers\ManufactureController::class, [ 'except' => ['show'] ])
    ->middleware('permission:master.manufactures.index|master.manufactures.create|master.manufactures.edit|master.manufactures.delete');

    Route::resource('/events', \App\Http\Controllers\EventController::class, [ 'except' => ['show'] ])
    ->middleware('permission:master.events.index|master.events.create|master.events.edit|master.events.delete');

    Route::resource('/services', \App\Http\Controllers\ServiceController::class, [ 'except' => ['show'] ])
    ->middleware('permission:master.services.index|master.services.create|master.services.edit|master.services.delete');

    Route::get('/registrations/import', [ \App\Http\Controllers\RegistrationController::class, 'import' ]);
    Route::post('/registrations/import', [ \App\Http\Controllers\RegistrationController::class, 'saveImport' ]);

    Route::resource('/registrations', \App\Http\Controllers\RegistrationController::class, [ 'only' => ['index', 'store'] ]);

    Route::get('/transactions', [ \App\Http\Controllers\Transaction\IndexController::class, 'index' ]);

    Route::group(['middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/transactions/registrations/{event}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'index' ]);
        Route::get('/transactions/registrations-show/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'show' ]);
        Route::delete('/transactions/registrations-delete/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'destroy' ]);
        Route::patch('/transactions/registrations-scan/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'scanManual' ]);
        Route::delete('/transactions/registration-delete-all/{event}', [\App\Http\Controllers\Transaction\RegistrationController::class, 'destroyAllNotScan']);
    });

    Route::group(['middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/trash/registrations/{event}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'index' ]);
        Route::get('/trash/registrations/restore/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'restore' ]);
        Route::get('/trash/registrations/delete/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'destroy' ]);
        Route::get('/trash/registrations/export',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'export' ]);
    });

    Route::resource('/users', \App\Http\Controllers\UserController::class)
    ->middleware('permission:setting.users.index|setting.users.create|setting.users.edit|setting.users.delete');

    Route::get('/permissions', [ \App\Http\Controllers\PermissionController::class, 'index' ])
    ->middleware('permission:setting.permissions.index');

    Route::resource('/roles', \App\Http\Controllers\RoleController::class, [ 'except' => [ 'show' ] ])
    ->middleware('permission:setting.roles.index|setting.roles.create|setting.roles.edit|setting.roles.delete');

    Route::get('/qr-code/registrations/download/{token}', [ \App\Http\Controllers\QrCode\RegistrationController::class, 'download' ]);

    Route::get('/term-condition', [ \App\Http\Controllers\TermConditionController::class, 'index']);

    Route::get('/reports', [ \App\Http\Controllers\Report\IndexController::class, 'index' ])
    ->middleware('permission:report.registrations.index');

    Route::get('/report/export/registrations/{event}', [\App\Http\Controllers\Report\RegistrationController::class, 'export'])
    ->middleware('permission:report.registrations.index');
    Route::get('/report/registrations/{event}', [ \App\Http\Controllers\Report\RegistrationController::class, 'index' ])
    ->middleware('permission:report.registrations.index');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
