<?php

use Illuminate\Http\Request;

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

// ===============================================For Users==========================
// Middleware to get user
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// router for Usercontroller
Route::apiResources(['user' => 'API\UserController']);
// ===============================================End For Users==========================

// ===============================================For Assets==========================
// Middleware to get Asset
Route::middleware('api')->get('/asset', function (Request $request) {
    return $request->asset();
});
// router for Asset Controller
Route::apiResources(['asset' => 'API\AssetController']);
// ===============================================End For Assets==========================

// ===============================================For Account Code==========================
// Middleware to get Asset
Route::middleware('api')->get('/accountcode', function (Request $request) {
    return $request->accountcode();
});
// router for Asset Controller
Route::apiResources(['accountcode' => 'API\AccountCodeController']);
// ===============================================End For Account Code==========================
// Router for the public profile
Route::get('profile', 'API\UserController@profile');
// Router for the search function
Route::get('findUser', 'API\UserController@search');
// send to User Controller
Route::put('profile', 'API\UserController@updateProfile');



// Route::get('add','CarController@create');
// Route::post('add','CarController@store');
// Route::get('car','CarController@index');
// Route::get('edit/{id}','CarController@edit');
// Route::post('edit/{id}','CarController@update');
// Route::delete('{id}','CarController@destroy');



