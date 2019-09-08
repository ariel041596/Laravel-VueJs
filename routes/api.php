<?php

use Illuminate\Http\Request;



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
Route::middleware('auth:api')->get('/asset', function (Request $request) {
    return $request->asset();
});
// router for Asset Controller
Route::apiResources(['asset' => 'API\AssetController']);
Route::middleware('auth:api')->get('/asset/par/{id}', function (Request $request) { //this is not working
    return $request->asset(); //this is not working
});                            //this is not working
// ===============================================End For Assets==========================
// ===============================================For IRRUP==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/disposal', function (Request $request) {
    return $request->disposal();
});
// router for Asset Controller
Route::apiResources(['disposal' => 'API\DisposalController']);
// ===============================================End For IRRUP==========================



// ===============================================For ICs==========================
// Middleware to get user
Route::middleware('auth:api')->get('/inventory', function (Request $request) {
    return $request->inventory();
});
// router for Usercontroller
Route::apiResources(['inventory' => 'API\InventoryController']);
// ===============================================End For ICS==========================


// ===============================================For Account Code==========================
// Middleware to get Account Code
Route::middleware('auth:api')->get('/accountcode', function (Request $request) {
    return $request->accountcode();
});
// router for Account Code Controller
Route::apiResources(['accountcode' => 'API\AccountCodeController']);
// ===============================================End For Account Code==========================

// Router to get the data of the certain id
// Route::get('asset', 'API\AssetController');
// Route::get('/api/asset', 'API\AssetController@index');
// Router for the public profile
// Route::get('{id}', 'API\AssetController@show');

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



