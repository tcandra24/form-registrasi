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
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function(){
      return redirect('/login');
    });
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register');


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

    Route::resource('/services', \App\Http\Controllers\ServiceController::class, [ 'except' => ['show'] ])
    ->middleware('permission:services.index|services.create|services.edit|services.delete');

    Route::resource('/registrations', \App\Http\Controllers\RegistrationController::class, [ 'only' => ['index', 'store'] ]);
    // ->middleware('permission:registrations.index');

    Route::resource('/transactions/registration', \App\Http\Controllers\TransactionsController::class, [ 'only' => ['index', 'destroy'] ]);

    Route::get('/transactions/trash',  [ \App\Http\Controllers\TrashController::class, 'index' ]);
    Route::get('/transactions/trash/restore/{id}',  [ \App\Http\Controllers\TrashController::class, 'restore' ]);
    Route::get('/transactions/trash/delete/{id}',  [ \App\Http\Controllers\TrashController::class, 'destroy' ]);

    Route::get('/users', [ \App\Http\Controllers\UserController::class, 'index' ])
    ->middleware('permission:users.index');

    Route::get('/permissions', [ \App\Http\Controllers\PermissionController::class, 'index' ])
    ->middleware('permission:permissions.index');

    Route::get('/roles', [ \App\Http\Controllers\RoleController::class, 'index' ])
    ->middleware('permission:roles.index');

    Route::get('/qr-code/download', [ \App\Http\Controllers\QrCodeController::class, 'download' ]);
    Route::get('/term-condition', [ \App\Http\Controllers\TermConditionController::class, 'index']);

    Route::get('/report/export/registrations', [\App\Http\Controllers\Report\RegistrationController::class, 'export'])
    ->middleware('permission:report_registrations.index');
    Route::get('/report/registrations', [ \App\Http\Controllers\Report\RegistrationController::class, 'index' ])
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
