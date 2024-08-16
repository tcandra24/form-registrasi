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
Route::get('/qr-code/show/{token}', [\App\Http\Controllers\QrCode\RegistrationController::class, 'show']);

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function(){
      return redirect('/login');
    });
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'store'])->name('register');

    Route::get('/login-admin', [App\Http\Controllers\AuthController::class, 'index']);
    Route::post('/login-admin', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

    // Route::get('/register', [App\Http\Controllers\AuthController::class, 'register']);
    // Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register');

    Route::get('/auth/{provider}', [App\Http\Controllers\SocialiteController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteController::class, 'handleProvideCallback']);
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [ App\Http\Controllers\DashboardController::class, 'index' ])
    ->middleware('permission:dashboard.index')->name('dashboard');

    Route::get('/show-on-monitor', [ App\Http\Controllers\DashboardController::class, 'showOnMonitor' ])->name('show-on-monitor');

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
    Route::resource('/registration-mechanics', \App\Http\Controllers\RegistrationMechanicsController::class, [ 'only' => ['index', 'store'] ]);

    Route::get('/transactions', [ \App\Http\Controllers\Transaction\IndexController::class, 'index' ]);

    Route::group(['prefix' => '/transactions/registrations','middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/{event}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'index' ]);
        Route::get('/{event}/show/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'show' ]);
        Route::patch('/{event}/change-status/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'updateIsScan' ]);
        Route::delete('/{event}/delete/{id}',  [ \App\Http\Controllers\Transaction\RegistrationController::class, 'destroy' ]);
        Route::delete('/{event}/delete-not-scan', [\App\Http\Controllers\Transaction\RegistrationController::class, 'destroyAllNotScan']);
    });

    Route::group(['prefix' => '/transactions/registration-mechanics','middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/{event}',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'index' ]);
        Route::get('/{event}/import',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'import' ]);
        Route::get('/{event}/create',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'create' ]);
        Route::post('/{event}/import',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'doImport' ]);
        Route::post('/{event}/store',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'store' ]);
        Route::patch('/{event}/change-status/{id}',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'updateIsScan' ]);
        Route::get('/{event}/show/{id}',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'show' ]);
        Route::delete('/{event}/delete/{id}',  [ \App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'destroy' ]);
        Route::delete('/{event}/delete-not-scan', [\App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'destroyAllNotScan']);
    });

    Route::group(['prefix' => '/trash/registrations','middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/{event}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'index' ]);
        Route::get('/{event}/restore/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'restore' ]);
        Route::get('/{event}/delete/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'destroy' ]);
        Route::get('/{event}/export',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'export' ]);
    });

    Route::group(['prefix' => '/trash/registration-mechanics','middleware' => ['permission:transaction.registrations.index']], function() {
        Route::get('/{event}',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'index' ]);
        Route::get('/{event}/restore/{id}',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'restore' ]);
        Route::get('/{event}/delete/{id}',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'destroy' ]);
        Route::get('/{event}/export',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'export' ]);
    });

    Route::resource('/users', \App\Http\Controllers\UserController::class)
    ->middleware('permission:setting.users.index|setting.users.create|setting.users.edit|setting.users.delete');

    Route::get('/permissions', [ \App\Http\Controllers\PermissionController::class, 'index' ])
    ->middleware('permission:setting.permissions.index');

    Route::resource('/roles', \App\Http\Controllers\RoleController::class, [ 'except' => [ 'show' ] ])
    ->middleware('permission:setting.roles.index|setting.roles.create|setting.roles.edit|setting.roles.delete');

    Route::get('/qr-code/registrations/download', [ \App\Http\Controllers\QrCode\RegistrationController::class, 'download' ]);
    Route::get('/qr-code/registration-mechanics/download', [ \App\Http\Controllers\QrCode\RegistrationMechanicController::class, 'download' ]);


    Route::get('/term-condition', [ \App\Http\Controllers\TermConditionController::class, 'index']);

    Route::get('/reports', [ \App\Http\Controllers\Report\IndexController::class, 'index' ])
    ->middleware('permission:report.registrations.index');

    Route::get('/report/export/registrations/{event}', [\App\Http\Controllers\Report\RegistrationController::class, 'export'])
    ->middleware('permission:report.registrations.index');
    Route::get('/report/registrations/{event}', [ \App\Http\Controllers\Report\RegistrationController::class, 'index' ])
    ->middleware('permission:report.registrations.index');

    Route::get('/report/export/registration-mechanics/{event}', [\App\Http\Controllers\Report\RegistrationMechanicController::class, 'export'])
    ->middleware('permission:report.registrations.index');
    Route::get('/report/registration-mechanics/{event}', [ \App\Http\Controllers\Report\RegistrationMechanicController::class, 'index' ])
    ->middleware('permission:report.registrations.index');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

// Route::get('/send-email',function(){
//     $data = [
//         'name' => 'Syahrizal As',
//         'body' => 'Testing Kirim Email di Santri Koding'
//     ];

//     Mail::to('tcandra007@gmail.com')->send(new SendEmailFromRegistration($data));

//     dd("Email Berhasil dikirim.");
// });
