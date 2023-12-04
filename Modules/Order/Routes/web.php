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
Route::group(['namespace' => '\Modules\Order\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {
    /*
     *
     *  Orders Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'orders';
    $controller_name = 'OrderController';
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Order\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Orders Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'orders';
    $controller_name = 'OrderController';
    Route::get("$module_name/masterfiles", ['as' => "$module_name.masterfiles", 'uses' => "$controller_name@masterfiles"]);
    Route::get("$module_name/masterdesignfiles", ['as' => "$module_name.masterdesignfiles", 'uses' => "$controller_name@masterdesignfiles"]);
    Route::get("$module_name/designfiles/{type?}", ['as' => "$module_name.designfiles", 'uses' => "$controller_name@designfiles"]);
    Route::get("$module_name/dividefile/{id}", ['as' => "$module_name.dividefile", 'uses' => "$controller_name@dividefile"]);
    Route::get("$module_name/changeStatus/{id}/{status}", ['as' => "$module_name.changeStatus", 'uses' => "$controller_name@changeStatus"]);
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/index_data2", ['as' => "$module_name.index_data2", 'uses' => "$controller_name@index_data2"]);
    Route::get("master_files/index_data", ['as' => "master_files.index_data", 'uses' => "$controller_name@master_files_data"]);
    Route::get("master_design_files/index_data", ['as' => "master_design_files.index_data", 'uses' => "$controller_name@master_design_files_data"]);
    Route::get("design_files/index_data/{type?}", ['as' => "design_files.index_data", 'uses' => "$controller_name@design_files_data"]);
    Route::get("design_files/delete_image/{id}", ['as' => "design_files.delete_image", 'uses' => "$controller_name@delete_image"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::get("$module_name/downloadAction/{file_name}/{id}", ['as' => "$module_name.downloadAction", 'uses' => "$controller_name@downloadAction"]);

    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");
});
