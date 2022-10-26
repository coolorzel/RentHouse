<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminPageSettings;
use App\Http\Controllers\SystemControl\FirstInstall;
use App\Http\Controllers\User\AvatarController;
use App\Http\Controllers\User\LinkUserController;
use App\Http\Controllers\User\MyUserProfile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

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




//____________________//
// FIRST INSTALLATION //
//____________________//
Route::group(['prefix' => 'firstInstall'], function() {
    Route::get('/', [FirstInstall::class, 'index'])->name('firstInstallIndex');
    Route::post('/', [FirstInstall::class, 'store'])->name('firstInstallStore');
});
Route::group(['middleware' => 'first_install'], function() {

    Auth::routes(['verify' => true]);

    //____________//
    // INDEX SITE //
    //____________//
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('index');


    //_____________________//
    // ADMIN CONTROL PANEL //
    //_____________________//
    Route::group(['prefix' => 'acp', 'middleware' => ['auth', 'permission:USER-view-myoffer']], function() {
        Route::get('/', [AdminDashboard::class, 'index'])->name('adminDashboard');
        Route::get('/statistics', [AdminDashboard::class, 'statistics'])->name('adminStatistics');
        Route::get('/settings', [AdminPageSettings::class, 'index'])->name('adminSettings');
        Route::post('/settings', [AdminPageSettings::class, 'store'])->name('adminSettingsStore');
        Route::get('/settings/test', [AdminPageSettings::class, 'create'])->name('adminSettingsTest');
    });

    //______________//
    // USER PROFILE //
    //______________//
    Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'verified']], function() {
        Route::get('/', [MyUserProfile::class, 'index'])->name('myProfile');
        Route::post('/update', [MyUserProfile::class, 'update'])->name('myProfileUpdate');
        Route::post('/updatePassword', [MyUserProfile::class, 'update_password'])->name('myPasswordUpdate');
        Route::post('/avatarUpdate', [AvatarController::class, 'update'])->name('myAvatarUpdate');
        Route::delete('/avatarDelete', [AvatarController::class, 'delete'])->name('myAvatarDelete');
        Route::get('/editLinkInfo/{nameLink}', [LinkUserController::class, 'edit'])->name('myLinksEdit');
        Route::post('/editLinkInfo')->name('myLinksEdit'); // ONLY FOR CHECK ADDRESS. GET IS CHECKED
        Route::post('/createLinkInfo', [LinkUserController::class, 'create'])->name('myLinksInfo');
        Route::post('/createLinkStore', [LinkUserController::class, 'store'])->name('myLinksCreate');
        Route::post('/updateLinkInfo/{nameLink}', [LinkUserController::class, 'update'])->name('myLinksUpdate');
        Route::get('/updateLinkInfo')->name('myLinksUpdate'); // ONLY FOR CHECK ADDRESS. GET IS CHECKED
        Route::delete('/deleteLinkInfo/{nameLink}', [LinkUserController::class, 'delete'])->name('myLinksDelete');
        Route::get('/deleteLinkInfo')->name('myLinksDelete');  // ONLY FOR CHECK ADDRESS. GET IS CHECKED
    });


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/postNewAd')->name('postNewAd');

});
