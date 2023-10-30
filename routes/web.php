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
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register');


    Route::get('/auth/{provider}', [App\Http\Controllers\SocialiteController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteController::class, 'handleProvideCallback']);
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [ App\Http\Controllers\DashboardController::class, 'index' ])
    ->middleware('permission:dashboard.index')->name('dashboard');

    Route::resource('/jobs', \App\Http\Controllers\JobController::class, [ 'except' => ['show'] ])
    ->middleware('permission:jobs.index|jobs.create|jobs.edit|jobs.delete');

    Route::resource('/shifts', \App\Http\Controllers\ShiftController::class, [ 'except' => ['show'] ])
    ->middleware('permission:shifts.index|shifts.create|shifts.edit|shifts.delete');

    Route::resource('/registrations', \App\Http\Controllers\RegistrationController::class, [ 'only' => ['index', 'store'] ])
    ->middleware('permission:regisrations.index');

    Route::get('/qr-code/download', [ \App\Http\Controllers\QrCodeController::class, 'download' ]);
    Route::get('/term-condition', [ \App\Http\Controllers\TermConditionController::class, 'index']);

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
