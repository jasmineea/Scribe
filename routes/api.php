<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('add-contact', 'addLisiting');
    Route::post('get-campaigns', 'getCampaigns');
    Route::post('delete-contact', 'deleteContact');
    Route::post('get-master-files', 'getMasterFiles');
});

// Route::group(['namespace' => 'App\Http\Controllers\Frontend', 'as' => 'frontend.'], function () {
//     Route::middleware('auth.api')->group(function (): void {
//         Route::post('/add-contact', 'FrontendController@addLisiting')->name('addLisiting');
//         Route::post('/get-campaigns', 'FrontendController@getCampaigns')->name('getCampaigns');
//         Route::post('/get-master-files', 'FrontendController@getMasterFiles')->name('getMasterFiles');
//     });
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
