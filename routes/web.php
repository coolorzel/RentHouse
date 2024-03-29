<?php

use App\Http\Controllers\Admin\AdminBillingAccount;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminElementFormController;
use App\Http\Controllers\Admin\AdminFormInCategoryController;
use App\Http\Controllers\Admin\AdminOfferCategory;
use App\Http\Controllers\Admin\AdminOfferController;
use App\Http\Controllers\Admin\AdminPageSettings;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\App\ContactController;
use App\Http\Controllers\App\OfferControllerController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\App\UserOffersController;
use App\Http\Controllers\App\UserOffersImagesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SystemControl\FirstInstall;
use App\Http\Controllers\SystemControl\siteIsOff;
use App\Http\Controllers\TEST;
use App\Http\Controllers\User\AvatarController;
use App\Http\Controllers\User\LinkUserController;
use App\Http\Controllers\User\MyUserProfile;
use App\Http\Controllers\User\UserBillingAccount;
use App\Http\Controllers\User\UserNotifications;
use App\Http\Response\BasicErrorResponse;
use App\Http\Response\BasicSuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//moje testy
Route::get('/tenantapplication', function(){
    return view('site.user.tenantapplication');
});

Route::get('/test2', function(){
    $response = new BasicErrorResponse("Test");


   return response()->json($response->asArray());
});

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
Route::get('/siteIsOff', [siteIsOff::class, 'index'])->name('siteIsOff');
Route::get('/test', [TEST::class, 'index']);

Route::group(['middleware' => 'first_install'], function() {

    Auth::routes([
        'verify' => true,
        'register'=>config('global.user_register_available', '1'),
    ]);
    Route::group(['middleware' => 'site_available'], function() {
        //____________//
        // INDEX SITE //
        //____________//
        Route::get('/', [HomeController::class, 'dashboard'])->name('index');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact/send', [ContactController::class, 'store'])->name('contactSendMessage');

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
            Route::group(['prefix' => 'billing', 'middleware' => ['permission:MOD-billing-account-view']], function() {
                Route::get('/', [AdminBillingAccount::class, 'index'])->name('adminUserBillingAccounts');
                Route::group(['prefix' => 'api', 'middleware' => ['permission:MOD-billing-account-api']], function (){
                    Route::post('/moreInfo/{billing}', [AdminBillingAccount::class, 'moreInfo'])->name('adminMoreInfoBillingAccount');
                    Route::post('/statusChanged/{billing}', [AdminBillingAccount::class, 'status_changed'])->middleware('permission:MOD-status-changed-billing-account')->name('adminStatusChangedBillingAccount');
                    Route::post('/sendRestored', [AdminBillingAccount::class, 'sendRestore'])->middleware('permission:MOD-message-restored-billing-account')->name('sendResponseBillingAccount');
                });
            });
            Route::group(['prefix' => 'contact', 'middleware' => ['permission:ACP-contact-view']], function() {
                Route::group(['prefix' => 'title', 'middleware' => ['permission:ACP-contact-title-view']], function() {
                    Route::get('/', [AdminContactController::class, 'titleIndex'])->name('adminContactTitle');
                    Route::post('/create', [AdminContactController::class, 'titleStore'])->middleware('permission:ACP-contact-title-create')->name('adminContactTitleCreate');
                    Route::post('/show/{title}', [AdminContactController::class, 'titleShow'])->middleware('permission:ACP-contact-title-show')->name('adminContactTitleShow');
                    Route::post('/edit/{title}', [AdminContactController::class, 'titleUpdate'])->middleware('permission:ACP-contact-title-edit')->name('adminContactTitleEdit');
                    Route::delete('/delete/{title}', [AdminContactController::class, 'titleDestroy'])->middleware('permission:ACP-contact-title-delete')->name('adminContactTitleDelete');
                });
                Route::group(['prefix' => 'message', 'middleware' => ['permission:ACP-contact-message-view']], function() {
                    Route::get('/', [AdminContactController::class, 'messageIndex'])->name('adminContactMessage');
                    Route::get('/show/{message}', [AdminContactController::class, 'messageShow'])->middleware('permission:ACP-contact-message-read')->name('adminContactMessageView');
                    Route::group(['prefix' => 'status'], function(){
                        Route::post('/operations/{message}', [AdminContactController::class, 'operations'])->name('contactMessageOperations');
                        Route::post('/readUnRead/{message}', [AdminContactController::class, 'statusReadUnRead'])->middleware('permission:ACP-contact-message-change-status-read-un-read')->name('adminContactMessageReadUnRead');
                        Route::post('/close/{message}', [AdminContactController::class, 'statusClose'])->middleware('permission:ACP-contact-message-change-status-close')->name('adminContactMessageClose');
                    });
                });
            });

            //__________________________//
            // Offer setting controller //
            //__________________________//
            Route::group(['prefix' => 'offer-controller', 'middleware' => ['permission:ACP-offers-controller-view']], function() {
                // ---- CATEGORY ---- //
                Route::group(['prefix' => 'categories', 'middleware' => ['permission:ACP-offers-category-view']], function() {
                    Route::get('/', [AdminOfferCategory::class, 'index'])->name('adminOffersControllerCategory');
                    Route::post('/create', [AdminOfferCategory::class, 'store'])->middleware('permission:ACP-offers-category-create')->name('adminOffersCategoryCreate');
                    Route::post('/show/{category}', [AdminOfferCategory::class, 'show'])->middleware('permission:ACP-offers-category-edit')->name('adminOffersCategoryShow');
                    Route::post('/edit/{category}', [AdminOfferCategory::class, 'update'])->middleware('permission:ACP-offers-category-edit')->name('adminOffersCategoryEdit');
                    Route::delete('/delete/{category}', [AdminOfferCategory::class, 'destroy'])->middleware('permission:ACP-offers-category-delete')->name('adminOffersCategoryDelete');
                });
                // ---- OFFER FORM IN CATEGORY ---- //
                Route::group(['prefix' => 'form-in-category', 'middleware' => ['permission:ACP-offers-form-in-category-view']], function() {
                    Route::get('/', [AdminFormInCategoryController::class, 'index'])->name('adminOffersControllerFormInCategory');
                    Route::post('/create', [AdminFormInCategoryController::class, 'store'])->middleware('permission:ACP-offers-form-in-category-create')->name('adminOffersFormInCategoryCreate');
                    Route::post('/show/{elementFormOffer}', [AdminFormInCategoryController::class, 'show'])->middleware('permission:ACP-offers-form-in-category-edit')->name('adminOffersFormInCategoryShow');
                    Route::post('/edit/{elementFormOffer}', [AdminFormInCategoryController::class, 'update'])->middleware('permission:ACP-offers-form-in-category-edit')->name('adminOffersFormInCategoryEdit');
                    Route::delete('/delete/{elementFormOffer}', [AdminFormInCategoryController::class, 'destroy'])->middleware('permission:ACP-offers-form-in-category-delete')->name('adminOffersFormInCategoryDelete');
                });
                // ---- ELEMENT FORM OFFER CONTROLLER ---- //
                Route::group(['prefix' => 'element-form-control', 'middleware' => ['permission:ACP-element-form-control-view']], function() {
                    Route::get('/{form}', [AdminElementFormController::class, 'index'])->name('adminElementFormController');
                    Route::post('/{form}/create', [AdminElementFormController::class, 'store'])->middleware('permission:ACP-element-form-control-create')->name('adminElementFormCreate');
                    Route::post('/{form}/{option}/show', [AdminElementFormController::class, 'show'])->middleware('permission:ACP-element-form-control-view')->name('adminElementFormShow');
                    Route::post('/{form}/{option}/update', [AdminElementFormController::class, 'update'])->middleware('permission:ACP-element-form-control-edit')->name('adminElementFormEdit');
                    Route::delete('/{form}/{option}/destroy', [AdminElementFormController::class, 'destroy'])->middleware('permission:ACP-element-form-control-delete')->name('adminElementFormDestroy');
                });
            });
            // ---- OFFERS VIEW AND MESSAGE ---- //
            Route::group(['prefix' => 'offers'], function(){
                Route::get('/', [AdminOfferController::class, 'index'])->name('adminOffersList');
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
            Route::group(['prefix' => 'billing', 'middleware' => ['verified']], function() {
                Route::get('/createVerification', [UserBillingAccount::class, 'create'])->name('myBillingVerificationForm');
                Route::post('/store', [UserBillingAccount::class, 'store'])->name('newBillingAccountCreate');
                Route::post('/checkStatusMessage/{billing}', [MyUserProfile::class, 'statusMessageBillingApplication'])->name('checkStatusMessage');
                Route::post('/sendMessageBillingAccount', [UserBillingAccount::class, 'sendMessage'])->name('userSendResponseBillingAccount');
            });
            Route::group(['prefix' => 'notification'], function() {
                Route::post('/', [UserNotifications::class, 'change'])->name('notificationChange');
                Route::post('/get', [UserNotifications::class, 'getValue'])->name('notificationGet');
            });
        });

        //___________________//
        // VIEW USER PROFILE //
        //___________________//
        Route::group(['prefix' => 'user'], function() {
            Route::get('/{user}', [UserController::class, 'show'])->name('viewUserProfile');
            Route::post('/update/{user}', [UserController::class, 'update'])->middleware('permission:ACP-update-user-profile')->name('updateUserProfile');
            Route::post('/activate/{user}', [AdminUserController::class, 'activateAccount'])->middleware('permission:ACP-user-activate-account')->name('activateUserAccount');
            Route::post('/changeRole/{user}', [AdminUserController::class, 'changeRoleUser'])->middleware('permission:ACP-user-role-change')->name('changeRoleUser');
            Route::post('/avatarUpdate/{user}', [AvatarController::class, 'update'])->middleware('permission:ACP-update-user-avatar')->name('updateUserAvatar');
            Route::delete('/avatarDelete/{user}', [AvatarController::class, 'delete'])->middleware('permission:ACP-delete-user-avatar')->name('deleteUserAvatar');
            Route::post('/createLinkInfo/{user}', [LinkUserController::class, 'create'])->middleware('permission:ACP-user-info-links')->name('userLinksInfo');
            Route::post('/createLinkStore/{user}', [LinkUserController::class, 'store'])->middleware('permission:ACP-user-create-link')->name('userLinkCreate');
            Route::get('/editLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'edit'])->middleware('permission:ACP-user-link-edit')->name('userLinkEdit');
            Route::post('/editLinkInfo')->name('userLinkEdit'); // ONLy FOR CHECK ADDRESS. GET IS CHECKED
            Route::post('/updateLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'update'])->whereNumber('user')->middleware('permission:ACP-user-link-update')->name('userLinkUpdate');
            Route::delete('/deleteLinkInfo/{user}/{nameLink}', [LinkUserController::class, 'delete'])->middleware('permission:ACP-user-link-delete')->name('userLinkDelete');

        });

        //_____________________________//
        // User view edit create offer //
        //_____________________________//
        //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');
        Route::group(['prefix' => 'postNewAd'], function (){
            Route::get('/', [OfferControllerController::class, 'select'])->name('postNewAd');
            Route::group(['middleware' => ['auth', 'verified', 'permission:LANDLORD-create-new-offer']], function() {
                Route::get('/{category}', [UserOffersController::class, 'create'])->name('offerCreate');
                Route::post('/{category}/{offer}/store', [UserOffersController::class, 'store'])->name('offerCreateStore');
                // ---- API and CONTROL images in Offer ---- //
                Route::group(['prefix' => 'images'], function() {
                   Route::post('/store/{category}/{offer}', [UserOffersImagesController::class, 'store'])->name('offerImagesStore');
                   Route::get('/fetch/{category}/{offer}', [UserOffersImagesController::class, 'fetch'])->name('offerImagesFetch');
                   Route::delete('/destroy/{category}/{offer}', [UserOffersImagesController::class, 'destroy'])->name('offerImagesDestroy');
                });
            });
        });
        Route::group(['prefix' => 'offers'], function(){
            Route::get('{category}')->name('searchInCategory');
            Route::get('{category}/{offer}/{slug}', [UserOffersController::class, 'show'])->name('offerShow');
            Route::get('{category}/{offer}/{slug}/edit', [UserOffersController::class, 'edit'])->name('offerEdit');
            Route::delete('{category}/{offer}/{slug}/destroy', [UserOffersController::class, 'destroy'])->name('offerDestroy');
        });
    });
});
