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

Route::get('/', function () {
//    return view('welcome');\
    return redirect('dashboard');
});

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/dashboard', function() {
    return view('home');
})->name('dashboard')->middleware('auth');
Route::post('dashboard/data', 'HomeController@data')->name('dashboard.data');

Route::resource('users', UserController::class)
    ->middleware('auth');

Route::resource('pendapatan', PendapatanController::class)
    ->middleware('auth');
Route::get('pendapatan/data/{periode}', 'PendapatanController@data')->name('pendapatan.data');
