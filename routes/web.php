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

Route::get('/link/{slug}', [App\Http\Controllers\Participant\LinkController::class, 'show'])->name('link.participant');

Route::group(['middleware' => ['guest:participant']], function () {
    Route::get('/', function(){
        return redirect('/login');
    });

    Route::get('/login', [App\Http\Controllers\Participant\AuthController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\Participant\AuthController::class, 'login'])->name('login.participant');

    Route::get('/register', [App\Http\Controllers\Participant\AuthController::class, 'register']);
    Route::post('/register', [App\Http\Controllers\Participant\AuthController::class, 'store'])->name('register.participant');

    Route::get('/provider/{provider}', [App\Http\Controllers\Participant\Vendor\AuthController::class, 'redirectToProvider'])->name('login.provider');
    Route::get('/provider/{provider}/callback', [App\Http\Controllers\Participant\Vendor\AuthController::class, 'handleProvideCallback']);
});

Route::group(['middleware' => ['auth:participant']], function () {
    Route::get('/', App\Http\Controllers\Participant\DashboardController::class)->name('participant.index');

    Route::get('/registrations/{event_id}', [\App\Http\Controllers\Participant\RegistrationController::class, 'create'])->name('create.registrations.participant');
    Route::post('/registrations', [\App\Http\Controllers\Participant\RegistrationController::class, 'store'])->name('store.registrations.participant');

    Route::get('/qr-code', [\App\Http\Controllers\Participant\QrCodeController::class, 'index'])->name('index.qr-code.participant');
    Route::get('/qr-code/show/{event_id}/{no_registration}', [\App\Http\Controllers\Participant\QrCodeController::class, 'show'])->name('show.qr-code.participant');

    Route::get('/term-condition', [ \App\Http\Controllers\Participant\TermConditionController::class, 'index'])->name('term-condition');

    Route::post('/logout', [App\Http\Controllers\Participant\AuthController::class, 'logout'])->name('logout.participant');
});


Route::prefix('admin')->group(function() {
    Route::group(['middleware' => ['guest:admin']], function () {
        Route::get('/', function(){
             return redirect('/admin/login');
        });

        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'index']);
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)
            ->middleware('permission:dashboard.index')->name('dashboard.index');

        Route::prefix('master')->group(function() {
            Route::resource('/jobs', \App\Http\Controllers\Admin\Master\JobController::class, [ 'except' => ['show'] ])
            ->middleware('permission:master.jobs.index|master.jobs.create|master.jobs.edit|master.jobs.delete');

            Route::resource('/shifts', \App\Http\Controllers\Admin\Master\ShiftController::class, [ 'except' => ['show'] ])
            ->middleware('permission:master.shifts.index|master.shifts.create|master.shifts.edit|master.shifts.delete');

            Route::resource('/manufactures', \App\Http\Controllers\Admin\Master\ManufactureController::class, [ 'except' => ['show'] ])
            ->middleware('permission:master.manufactures.index|master.manufactures.create|master.manufactures.edit|master.manufactures.delete');

            Route::resource('/events', \App\Http\Controllers\Admin\Master\EventController::class, [ 'except' => ['show'] ])
            ->middleware('permission:master.events.index|master.events.create|master.events.edit|master.events.delete');

            Route::resource('/services', \App\Http\Controllers\Admin\Master\ServiceController::class, [ 'except' => ['show'] ])
            ->middleware('permission:master.services.index|master.services.create|master.services.edit|master.services.delete');
        });

        Route::prefix('transaction')->group(function() {
            Route::resource('/registrations', \App\Http\Controllers\Admin\Transaction\RegistrationController::class, [ 'only' => ['index', 'show'] ])
            ->middleware('permission:transaction.registrations.index')->names([
                'index' => 'transaction.registrations.index',
                'show' => 'transaction.registrations.show',
            ]);

            Route::resource('/participants', \App\Http\Controllers\Admin\Transaction\ParticipantController::class, [ 'only' => ['index'] ])
            ->middleware('permission:transaction.participants.index')->names([
                'index' => 'transaction.participants.index'
            ]);

            Route::delete('/registration/{event_id}/{registration_number}', [ \App\Http\Controllers\Admin\Transaction\RegistrationController::class, 'destroy' ])->name('transaction.registrations.delete');

            Route::get('/trash/{event_id}', [ \App\Http\Controllers\Admin\Transaction\TrashController::class, 'show' ])->name('transaction.trash.show');
            Route::post('/trash/{event_id}/{registration_number}', [ \App\Http\Controllers\Admin\Transaction\TrashController::class, 'restore' ])->name('transaction.trash.restore');
        });

        Route::prefix('report')->group(function() {
            Route::resource('/registrations', \App\Http\Controllers\Admin\Report\RegistrationController::class, [ 'only' => ['index', 'show'] ])
            ->middleware('permission:transaction.registrations.index')->names([
                'index' => 'report.registrations.index',
                'show' => 'report.registrations.show',
            ]);

            Route::get('/export/{event_id}',  [ \App\Http\Controllers\Admin\Report\UtilityController::class, 'export' ])->name('report.registrations.export');
        });

        Route::prefix('setting')->group(function() {
            Route::resource('/users', \App\Http\Controllers\Admin\Setting\UserController::class)
            ->middleware('permission:setting.users.index|setting.users.create|setting.users.edit|setting.users.delete');

            Route::resource('/form-fields', \App\Http\Controllers\Admin\Setting\FormFieldController::class)
            ->middleware('permission:setting.form_fields.index|setting.form_fields.create|setting.form_fields.edit|setting.form_fields.delete');

            Route::resource('/permissions', \App\Http\Controllers\Admin\Setting\PermissionController::class, [ 'only' => [ 'index', 'create', 'store' ] ])
            ->middleware('permission:setting.permissions.index');

            Route::resource('/roles', \App\Http\Controllers\Admin\Setting\RoleController::class, [ 'except' => [ 'show' ] ])
            ->middleware('permission:setting.roles.index|setting.roles.create|setting.roles.edit|setting.roles.delete');
        });

        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    });
});

