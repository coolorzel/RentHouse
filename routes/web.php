<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminPageSettings;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\SystemControl\FirstInstall;
use App\Http\Controllers\User\AvatarController;
use App\Http\Controllers\User\LinkUserController;
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
    Route::group(['prefix' => 'acp', 'middleware' => ['auth', 'permission:ACP-view']], function() {
        Route::get('/', [AdminDashboard::class, 'index'])->name('adminDashboard');
        Route::get('/statistics', [AdminDashboard::class, 'statistics'])->name('adminStatistics');
        Route::group(['prefix' => 'settings', 'middleware' => ['permission:ACP-settings']], function() {
            Route::get('/', [AdminPageSettings::class, 'index'])->name('adminSettings');
            Route::post('/store', [AdminPageSettings::class, 'store'])->middleware('permission:ACP-update-settings-site')->name('adminSettingsStore');
            Route::post('/availableSite', [AdminPageSettings::class, 'availableSite'])->middleware('permission:ACP-change-available-site')->name('adminSettingAvailable');
        });
        Route::group(['prefix' => 'users', 'middleware' => ['permission:ACP-user-list-view']], function() {
            Route::get('/', [AdminUserController::class, 'profile'])->name('adminUserProfile');
            Route::post('/userInfo', [AdminUserController::class, 'userInfo'])->name('adminUserInfo');
        });
        Route::group(['prefix' => 'roles', 'middleware' => ['permission:ACP-roles-view']], function() {
            Route::get('/', [RolesController::class, 'index'])->name('adminUserRoles');
            Route::post('/create', [RolesController::class, 'store'])->middleware('permission:ACP-role-create')->name('adminRoleCreate');
            Route::post('/show/{role}', [RolesController::class, 'show'])->middleware('permission:ACP-role-edit')->name('adminRoleShow');
            Route::post('/edit/{role}', [RolesController::class, 'update'])->middleware('permission:ACP-role-edit')->name('adminRoleEdit');
            Route::delete('/destroy/{role}', [RolesController::class, 'destroy'])->middleware('permission:ACP-role-delete')->name('adminRoleDelete');
        });
        Route::group(['prefix' => 'permissions', 'middleware' => ['permission:ACP-permissions-view']], function() {
            Route::get('/', [PermissionsController::class, 'index'])->name('adminUserPermissions');
            Route::post('/create', [PermissionsController::class, 'store'])->middleware('permission:ACP-permission-create')->name('adminPermissionCreate');
            Route::post('/show/{permission}', [PermissionsController::class, 'show'])->middleware('permission:ACP-permission-edit')->name('adminPermissionShow');
            Route::post('/edit/{permission}', [PermissionsController::class, 'update'])->middleware('permission:ACP-permission-edit')->name('adminPermissionEdit');
            Route::delete('/destroy/{permission}', [PermissionsController::class, 'destroy'])->middleware('permission:ACP-permission-delete')->name('adminPermissionDelete');
        });
    });

    //______________//
    // USER PROFILE //
    //______________//
    Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function() {
        Route::get('/', [MyUserProfile::class, 'index'])->name('myProfile');
        Route::post('/update', [MyUserProfile::class, 'update'])->middleware('permission:USER-my-profile-update')->name('myProfileUpdate');
        Route::post('/updatePassword', [MyUserProfile::class, 'update_password'])->middleware('permission:USER-my-password-update')->name('myPasswordUpdate');
        Route::post('/avatarUpdate', [AvatarController::class, 'update'])->middleware('permission:USER-my-avatar-update')->name('myAvatarUpdate');
        Route::delete('/avatarDelete', [AvatarController::class, 'delete'])->middleware('permission:USER-my-avatar-delete')->name('myAvatarDelete');
        Route::get('/editLinkInfo/{nameLink}', [LinkUserController::class, 'edit'])->middleware('permission:USER-my-link-edit')->name('myLinksEdit');
        Route::post('/editLinkInfo')->name('myLinksEdit'); // ONLY FOR CHECK ADDRESS. GET IS CHECKED
        Route::post('/createLinkInfo', [LinkUserController::class, 'create'])->name('myLinksInfo');
        Route::post('/createLinkStore', [LinkUserController::class, 'store'])->middleware('permission:USER-my-link-create')->name('myLinksCreate');
        Route::post('/updateLinkInfo/{nameLink}', [LinkUserController::class, 'update'])->middleware('permission:USER-my-link-update')->name('myLinksUpdate');
        Route::get('/updateLinkInfo')->name('myLinksUpdate'); // ONLY FOR CHECK ADDRESS. GET IS CHECKED
        Route::delete('/deleteLinkInfo/{nameLink}', [LinkUserController::class, 'delete'])->middleware('permission:USER-my-link-delete')->name('myLinksDelete');
        Route::get('/deleteLinkInfo')->name('myLinksDelete');  // ONLY FOR CHECK ADDRESS. GET IS CHECKED
    });

    //___________________//
    // VIEW USER PROFILE //
    //___________________//
    Route::group(['prefix' => 'user'], function() {
        Route::get('/{user}', [UserController::class, 'show'])->name('viewUserProfile');
        Route::post('/update/{user}', [UserController::class, 'update'])->middleware('permission:ACP-update-user-profile')->name('updateUserProfile');
        Route::post('/avatarUpdate/{user}', [AvatarController::class, 'update'])->middleware('permission:ACP-update-user-avatar')->name('updateUserAvatar');
        Route::delete('/avatarDelete/{user}', [AvatarController::class, 'delete'])->middleware('permission:ACP-delete-user-avatar')->name('deleteUserAvatar');
        Route::post('/createLinkInfo/{user}', [LinkUserController::class, 'create'])->middleware('permission:ACP-user-info-links')->name('userLinksInfo');
        Route::post('/createLinkStore/{user}', [LinkUserController::class, 'store'])->middleware('permission:ACP-user-create-link')->name('userLinkCreate');
        Route::get('/editLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'edit'])->middleware('permission:ACP-user-link-edit')->name('userLinkEdit');
        Route::post('/editLinkInfo')->name('userLinkEdit'); // ONLy FOR CHECK ADDRESS. GET IS CHECKED
        Route::post('/updateLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'update'])->whereNumber('user')->middleware('permission:ACP-user-link-update')->name('userLinkUpdate');
        Route::delete('/deleteLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'delete'])->middleware('permission:ACP-user-link-delete')->name('userLinkDelete');

    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/postNewAd')->name('postNewAd');

});
