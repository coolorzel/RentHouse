<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminPageSettings;
use App\Http\Controllers\SystemControl\FirstInstall;
use App\Http\Controllers\User\MyUserProfile;
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

//____________________//
// FIRST INSTALLATION //
//____________________//
Route::group(['prefix' => 'firstInstall'], function() {
    Route::get('/', [FirstInstall::class, 'index'])->name('firstInstallIndex');
    Route::post('/store', [FirstInstall::class, 'store'])->name('firstInstallStore');
});

//_____________________//
// ADMIN CONTROL PANEL //
//_____________________//
Route::group(['prefix' => 'acp', 'middleware' => ['permission:USER-view-myoffer']], function() {
    Route::get('/', [AdminDashboard::class, 'index'])->name('adminDashboard');
    Route::get('/statistics', [AdminDashboard::class, 'statistics'])->name('adminStatistics');
    Route::get('/settings', [AdminPageSettings::class, 'index'])->name('adminSettings');
    Route::post('/settings', [AdminPageSettings::class, 'store'])->name('adminSettingsStore');
});

//______________//
// USER PROFILE //
//______________//
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function() {
    Route::get('/', [MyUserProfile::class, 'index'])->name('myProfile');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/postNewAd')->name('postNewAd');
