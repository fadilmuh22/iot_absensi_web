<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/user/verify/{token}', [App\Http\Controllers\Auth\RegisterController::class, 'verifyUser']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/events', [App\Http\Controllers\HomeController::class, 'events'])->name('events');
Route::get('/event/{event_id}', [App\Http\Controllers\HomeController::class, 'event'])->name('event');
Route::delete('/event/delete/{absen_id}', [HomeController::class, 'absenDelete']);

Route::get('/create-token/{event_id}', [App\Http\Controllers\EventController::class, 'createToken']);
Route::get('/resend-token/{event_id}', [App\Http\Controllers\EventController::class, 'resendToken']);

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('/settings', function () {
        return view('admin.settings');
    });

    Route::post('/reset-password', [HomeController::class, 'resetPassword']);

    Route::group(['prefix' => 'event'], function () {

        Route::get('/', [EventController::class, 'index']);
        Route::get('/json', [EventController::class, 'dataTables']);

        Route::get('/create', [EventController::class, 'create']);
        Route::post('/store', [EventController::class, 'store']);

        Route::get('/edit/{event_id}', [EventController::class, 'edit']);
        Route::put('/update/{event_id}', [EventController::class, 'update']);

        Route::delete('/delete/{event_id}', [EventController::class, 'destroy']);
        Route::get('/export-absen/{event_id}', [EventController::class, 'exportAbsens']);

        Route::get('/absen-list/{event_id}', [EventController::class, 'absenList']);
        Route::get('/absen-json/{event_id}', [EventController::class, 'absenJson']);
        Route::delete('/absen-delete/{absen_id}', [EventController::class, 'absenDelete']);
    });
});
