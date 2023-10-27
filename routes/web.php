<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');

    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register');


    Route::get('/auth/{provider}', [App\Http\Controllers\SocialiteController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteController::class, 'handleProvideCallback']);
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [ App\Http\Controllers\DashboardController::class, 'index' ])->name('dashboard');

    Route::resource('/jobs', \App\Http\Controllers\JobController::class);
    Route::resource('/shifts', \App\Http\Controllers\ShiftController::class);

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
