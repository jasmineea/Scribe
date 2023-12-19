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

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Customer\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {
    /*
     *
     *  Customers Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'customers';
    $controller_name = 'CustomerController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/{id}/{slug?}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Customer\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Customers Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'customers';
    $controller_name = 'CustomerController';
    Route::post("$module_name/wallet_recharge", ['as' => "$module_name.wallet_recharge", 'uses' => "$controller_name@wallet_recharge"]);
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/contacts_data/{id}", ['as' => "$module_name.contacts_data", 'uses' => "$controller_name@contacts_data"]);
    Route::get("$module_name/details/{id}", ['as' => "$module_name.details", 'uses' => "$controller_name@details"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::get("$module_name/refresh-token/{id}", ['as' => "$module_name.refresh_token", 'uses' => "$controller_name@refresh_token"]);
    Route::resource("$module_name", "$controller_name");
});
