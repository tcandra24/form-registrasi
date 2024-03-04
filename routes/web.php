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

    Route::resource('/jobs', \App\Http\Controllers\JobController::class, [ 'except' => ['show'] ])
    ->middleware('permission:jobs.index|jobs.create|jobs.edit|jobs.delete');

    Route::resource('/shifts', \App\Http\Controllers\ShiftController::class, [ 'except' => ['show'] ])
    ->middleware('permission:shifts.index|shifts.create|shifts.edit|shifts.delete');

    Route::resource('/manufactures', \App\Http\Controllers\ManufactureController::class, [ 'except' => ['show'] ])
    ->middleware('permission:manufactures.index|manufactures.create|manufactures.edit|manufactures.delete');

    Route::resource('/events', \App\Http\Controllers\EventController::class, [ 'except' => ['show'] ])
    ->middleware('permission:events.index|events.create|events.edit|events.delete');

    Route::resource('/services', \App\Http\Controllers\ServiceController::class, [ 'except' => ['show'] ])
    ->middleware('permission:services.index|services.create|services.edit|services.delete');

    Route::get('/registrations/import', [ \App\Http\Controllers\RegistrationController::class, 'import' ]);
    Route::post('/registrations/import', [ \App\Http\Controllers\RegistrationController::class, 'saveImport' ]);

    Route::resource('/registrations', \App\Http\Controllers\RegistrationController::class, [ 'only' => ['index', 'store'] ]);
    Route::resource('/registration-mechanics', \App\Http\Controllers\RegistrationMechanicsController::class, [ 'only' => ['index', 'store'] ]);

    Route::get('/transactions', [ \App\Http\Controllers\Transaction\IndexController::class, 'index' ]);

    Route::delete('/transactions/registration/delete-all-not-scan', [\App\Http\Controllers\Transaction\RegistrationController::class, 'destroyAllNotScan']);
    Route::resource('/transactions/registrations/{slug}', \App\Http\Controllers\Transaction\RegistrationController::class, [ 'only' => ['index', 'show', 'destroy'] ]);

    Route::delete('/transactions/registration-mechanics/delete-all-not-scan', [\App\Http\Controllers\Transaction\RegistrationMechanicController::class, 'destroyAllNotScan']);
    Route::resource('/transactions/registration-mechanics/{slug}', \App\Http\Controllers\Transaction\RegistrationMechanicController::class, [ 'only' => ['index', 'show', 'destroy'] ]);

    Route::get('/trash/registrations',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'index' ]);
    Route::get('/trash/registrations/restore/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'restore' ]);
    Route::get('/trash/registrations/delete/{id}',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'destroy' ]);

    Route::get('/trash/registrations/export',  [ \App\Http\Controllers\Trash\RegistrationController::class, 'export' ]);

    Route::get('/trash/registration-mechanics',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'index' ]);
    Route::get('/trash/registration-mechanics/restore/{id}',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'restore' ]);
    Route::get('/trash/registration-mechanics/delete/{id}',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'destroy' ]);

    Route::get('/trash/registration-mechanics/export',  [ \App\Http\Controllers\Trash\RegistrationMechanicController::class, 'export' ]);

    Route::get('/users', [ \App\Http\Controllers\UserController::class, 'index' ])
    ->middleware('permission:users.index');

    Route::get('/permissions', [ \App\Http\Controllers\PermissionController::class, 'index' ])
    ->middleware('permission:permissions.index');

    Route::resource('/roles', \App\Http\Controllers\RoleController::class, [ 'except' => [ 'show' ] ])
    ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

    Route::get('/qr-code/registrations/download', [ \App\Http\Controllers\QrCode\RegistrationController::class, 'download' ]);
    Route::get('/qr-code/registration-mechanics/download', [ \App\Http\Controllers\QrCode\RegistrationMechanicController::class, 'download' ]);


    Route::get('/term-condition', [ \App\Http\Controllers\TermConditionController::class, 'index']);

    Route::get('/reports', [ \App\Http\Controllers\Report\IndexController::class, 'index' ])
    ->middleware('permission:report_registrations.index');

    Route::get('/report/export/registrations', [\App\Http\Controllers\Report\RegistrationController::class, 'export'])
    ->middleware('permission:report_registrations.index');
    Route::get('/report/registrations', [ \App\Http\Controllers\Report\RegistrationController::class, 'index' ])
    ->middleware('permission:report_registrations.index');

    Route::get('/report/export/registration-mechanics', [\App\Http\Controllers\Report\RegistrationMechanicController::class, 'export'])
    ->middleware('permission:report_registrations.index');
    Route::get('/report/registration-mechanics', [ \App\Http\Controllers\Report\RegistrationMechanicController::class, 'index' ])
    ->middleware('permission:report_registrations.index');

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
