<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

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

// Auth Routes
require __DIR__.'/auth.php';

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('dashboard', 'App\Http\Controllers\Frontend\FrontendController@index')->name('dashboard');
/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => 'App\Http\Controllers\Frontend', 'as' => 'frontend.'], function () {
    Route::get('/', 'FrontendController@index')->name('index');

    Route::get('home', 'FrontendController@index')->name('home');
    Route::get('privacy', 'FrontendController@privacy')->name('privacy');
    Route::get('terms', 'FrontendController@terms')->name('terms');
    Route::get('auto-create-order/{type?}', ['as' => "cards.autoCreateOrder", 'uses' => "CardController@autoCreateOrder"]);

    Route::get('createMasterFile/{type?}', ['as' => "cards.createMasterFile", 'uses' => "CardController@createMasterFile"]);
    Route::get('exportFile/{list_id}', ['as' => "cards.exportFile", 'uses' => "CardController@exportFile"]);
    Route::get('createcontacts/{order_id}/{start}', ['as' => "cards.createcontacts", 'uses' => "CardController@createcontacts"]);

    Route::group(['middleware' => ['auth']], function () {
        /*
        *
        *  Users Routes
        *
        * ---------------------------------------------------------------------
        */
        $module_name = 'users';
        $controller_name = 'UserController';
        Route::get('profile/{id}', ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
        Route::get('profile/{id}/edit', ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
        Route::patch('profile/{id}/edit', ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
        Route::get('profile/changePassword/{username}', ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
        Route::patch('profile/changePassword/{username}', ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
        Route::get("$module_name/emailConfirmationResend/{id}", ['as' => "$module_name.emailConfirmationResend", 'uses' => "$controller_name@emailConfirmationResend"]);
        Route::delete("$module_name/userProviderDestroy", ['as' => "$module_name.userProviderDestroy", 'uses' => "$controller_name@userProviderDestroy"]);

        /*
        *
        *  Card Creation Steps
        *
        * ---------------------------------------------------------------------
        */

        $module_name = 'cards';
        $controller_name = 'CardController';

        Route::get('step-1', ['as' => "$module_name.step1", 'uses' => "$controller_name@step0"]);
        Route::post('step-1', ['as' => "$module_name.step1Update", 'uses' => "$controller_name@step0Update"]);

        Route::get('step-2', ['as' => "$module_name.step2", 'uses' => "$controller_name@step1"]);
        Route::post('step-2', ['as' => "$module_name.step2Update", 'uses' => "$controller_name@step1Update"]);

        Route::get('step-2a', ['as' => "$module_name.step2a", 'uses' => "$controller_name@step2a"]);
        Route::post('step-2a', ['as' => "$module_name.step2aUpdate", 'uses' => "$controller_name@step2aUpdate"]);

        Route::get('step-3', ['as' => "$module_name.step3", 'uses' => "$controller_name@step2"]);
        Route::post('step-3', ['as' => "$module_name.step3Update", 'uses' => "$controller_name@step3Update"]);

        Route::post('create_list', ['as' => "$module_name.step2ListCreate", 'uses' => "$controller_name@step2ListCreate"]);

        Route::get('step-3a', ['as' => "$module_name.step3a", 'uses' => "$controller_name@step3"]);
        Route::post('step-3a', ['as' => "$module_name.step3aUpdate", 'uses' => "$controller_name@step3aUpdate"]);

        Route::get('step-4', ['as' => "$module_name.step4", 'uses' => "$controller_name@step4"]);
        Route::post('step-4', ['as' => "$module_name.step4Update", 'uses' => "$controller_name@step4Update"]);

        Route::get('step-4a', ['as' => "$module_name.step4a", 'uses' => "$controller_name@step4a"]);
        Route::post('step-4a', ['as' => "$module_name.step4aUpdate", 'uses' => "$controller_name@step4aUpdate"]);

        Route::get('step-4b', ['as' => "$module_name.step4b", 'uses' => "$controller_name@step4b"]);
        Route::post('step-4b', ['as' => "$module_name.step4bUpdate", 'uses' => "$controller_name@step4bUpdate"]);

        Route::get('step-5', ['as' => "$module_name.step5", 'uses' => "$controller_name@step4"]);
        Route::post('step-5', ['as' => "$module_name.step5Update", 'uses' => "$controller_name@step5Update"]);

        Route::get('thank-you', ['as' => "$module_name.thankYou", 'uses' => "$controller_name@thankYou"]);
        Route::get('wallet', ['as' => "$module_name.wallet", 'uses' => "$controller_name@wallet"]);
        Route::post('wallet', ['as' => "$module_name.wallet", 'uses' => "$controller_name@wallet"]);

        Route::post('card-design-upload', ['as' => "$module_name.cardDesignUpload", 'uses' => "$controller_name@cardDesignUpload"]);
        Route::post('save-design-type', ['as' => "$module_name.saveDesignType", 'uses' => "$controller_name@saveDesignType"]);
        Route::post('delete-design-file', ['as' => "$module_name.DeleteDesignFile", 'uses' => "$controller_name@DeleteDesignFile"]);

        Route::get('orders', ['as' => "$module_name.orders", 'uses' => "$controller_name@orders"]);
        Route::get('listing', ['as' => "$module_name.listing", 'uses' => "$controller_name@listing"]);
        Route::get('listing/{id}', ['as' => "$module_name.contacts", 'uses' => "$controller_name@contacts"]);
        Route::get('files/{file_name}', ['as' => "$module_name.files", 'uses' => "$controller_name@files"]);

        Route::post('create-stripe-token', ['as' => "$module_name.createStripeToken", 'uses' => "$controller_name@createStripeToken"]);
        Route::post('deduct_payment', ['as' => "$module_name.deductPaymentFromSavedCard", 'uses' => "$controller_name@deductPaymentFromSavedCard"]);

        Route::get('create-stripe-element', ['as' => "$module_name.createStripeElement", 'uses' => "$controller_name@createStripeElement"]);
        Route::get('create-stripe-element-popup', ['as' => "$module_name.createStripeElementPopup", 'uses' => "$controller_name@createStripeElementPopup"]);
        Route::get('term-conditions', ['as' => "$module_name.termConditions", 'uses' => "$controller_name@termConditions"]);
        Route::get('payment', ['as' => "$module_name.squareupPage", 'uses' => "$controller_name@squareupPage"]);
        Route::post('paymentResponse', ['as' => "$module_name.paymentResponse", 'uses' => "$controller_name@paymentResponse"]);
        Route::post('storeCard', ['as' => "$module_name.storeCard", 'uses' => "$controller_name@storeCard"]);
        Route::post('deleteCard', ['as' => "$module_name.deleteCard", 'uses' => "$controller_name@deleteCard"]);
        Route::get('zapierImport', ['as' => "$module_name.zapierImport", 'uses' => "$controller_name@zapierImport"]);
        Route::get('makeImport', ['as' => "$module_name.makeImport", 'uses' => "$controller_name@makeImport"]);

        Route::get('order-detail/{id}', ['as' => "$module_name.orderDetail", 'uses' => "$controller_name@orderDetail"]);
        Route::get('order-edit/{id}', ['as' => "$module_name.orderEdit", 'uses' => "$controller_name@orderEdit"]);
        Route::get('update-status/{id}/{status}', ['as' => "$module_name.updateStatus", 'uses' => "$controller_name@updateStatus"]);
        Route::post('update-status/{id}/{status}', ['as' => "$module_name.updateStatus", 'uses' => "$controller_name@updateStatus"]);
        Route::get('duplicate-drder/{id}', ['as' => "$module_name.duplicateOrder", 'uses' => "$controller_name@duplicateOrder"]);
        Route::post('uploadFile', ['as' => "$module_name.uploadFile", 'uses' => "$controller_name@uploadFile"]);
        Route::get('generateFiles/{id}/{type?}', ['as' => "$module_name.generateFiles", 'uses' => "$controller_name@generateFiles"]);
        Route::post('uploadPreBccFile', ['as' => "$module_name.uploadPreBccFile", 'uses' => "$controller_name@uploadPreBccFile"]);

    });
});

/*
*
* Backend Routes
* These routes need view-backend permission
* --------------------------------------------------------------------
*/
Route::group(['namespace' => 'App\Http\Controllers\Backend', 'prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'can:view_backend']], function () {
    /**
     * Backend Dashboard
     * Namespaces indicate folder structure.
     */
    Route::get('/', 'BackendController@index')->name('home');
    Route::get('dashboard', 'BackendController@index')->name('dashboard');
    Route::get('search', 'BackendController@search')->name('search');

    /*
     *
     *  Settings Routes
     *
     * ---------------------------------------------------------------------
     */
    Route::group(['middleware' => ['permission:edit_settings']], function () {
        $module_name = 'settings';
        $controller_name = 'SettingController';
        Route::get("$module_name", "$controller_name@index")->name("$module_name");
        Route::post("$module_name", "$controller_name@store")->name("$module_name.store");
    });

    /*
    *
    *  Notification Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'notifications';
    $controller_name = 'NotificationsController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/markAllAsRead", ['as' => "$module_name.markAllAsRead", 'uses' => "$controller_name@markAllAsRead"]);
    Route::delete("$module_name/deleteAll", ['as' => "$module_name.deleteAll", 'uses' => "$controller_name@deleteAll"]);
    Route::get("$module_name/{id}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);

    /*
    *
    *  Backup Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'backups';
    $controller_name = 'BackupController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/create", ['as' => "$module_name.create", 'uses' => "$controller_name@create"]);
    Route::get("$module_name/download/{file_name}", ['as' => "$module_name.download", 'uses' => "$controller_name@download"]);
    Route::get("$module_name/delete/{file_name}", ['as' => "$module_name.delete", 'uses' => "$controller_name@delete"]);

    /*
    *
    *  Roles Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'roles';
    $controller_name = 'RolesController';
    Route::resource("$module_name", "$controller_name");

    /*
    *
    *  Users Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'users';
    $controller_name = 'UserController';
    Route::get("$module_name/profile/{id}", ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
    Route::get("$module_name/profile/{id}/edit", ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
    Route::patch("$module_name/profile/{id}/edit", ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
    Route::get("$module_name/emailConfirmationResend/{id}", ['as' => "$module_name.emailConfirmationResend", 'uses' => "$controller_name@emailConfirmationResend"]);
    Route::delete("$module_name/userProviderDestroy", ['as' => "$module_name.userProviderDestroy", 'uses' => "$controller_name@userProviderDestroy"]);
    Route::get("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePassword", 'uses' => "$controller_name@changeProfilePassword"]);
    Route::patch("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePasswordUpdate", 'uses' => "$controller_name@changeProfilePasswordUpdate"]);
    Route::get("$module_name/changePassword/{id}", ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
    Route::patch("$module_name/changePassword/{id}", ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::resource("$module_name", "$controller_name");
    Route::patch("$module_name/{id}/block", ['as' => "$module_name.block", 'uses' => "$controller_name@block", 'middleware' => ['permission:block_users']]);
    Route::patch("$module_name/{id}/unblock", ['as' => "$module_name.unblock", 'uses' => "$controller_name@unblock", 'middleware' => ['permission:block_users']]);
});
