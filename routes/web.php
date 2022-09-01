<?php

use App\Http\Controllers\SystemControl\FirstInstall;
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
    return view('site.dashboard');
})->name('index');

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'firstInstall'], function() {
    Route::get('/', [FirstInstall::class, 'index'])->name('firstInstallIndex');
    Route::post('/store', [FirstInstall::class, 'store'])->name('firstInstallStore');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/postNewAd')->name('postNewAd');
