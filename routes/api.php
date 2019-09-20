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
// ===============================================For Accountable Officers==========================
// Middleware to get user
Route::middleware('auth:api')->get('/accountable_officer', function (Request $request) {
    return $request->accountable_officer();
});
// router for Usercontroller
Route::apiResources(['accountable_officer' => 'API\AccountOfficerController']);
// ===============================================End For Accountable Officers==========================
// ===============================================For Account Codes==========================
// Middleware to get user
Route::middleware('auth:api')->get('/account_code', function (Request $request) {
    return $request->account_code();
});
// router for Usercontroller
Route::apiResources(['account_code' => 'API\AccountCodeController']);
// ===============================================End For Account Codes==========================
// ===============================================For Users Type==========================
// Middleware to get user
Route::middleware('auth:api')->get('/users_type', function (Request $request) {
    return $request->users_type();
});
// router for Usercontroller
Route::apiResources(['users_type' => 'API\UsersTypeController']);
// ===============================================End For Users Type==========================


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
// ===============================================For Assets Pending==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/pending', function (Request $request) {
    return $request->pending();
});
// router for Asset Controller
Route::apiResources(['pending' => 'API\AssetPendingController']);

// ===============================================For Assets Inventory/ICS==========================
// Middleware to get Asset of an employee
Route::middleware('auth:api')->get('/accountabilities', function (Request $request) {
    return $request->accountabilities();
});
// router for Asset Controller of an employee
Route::apiResources(['accountabilities' => 'API\AccountabilityController']);

// ===============================================For Assets of employee==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/inventory', function (Request $request) {
    return $request->inventory();
});
// router for Asset Controller
Route::apiResources(['inventory' => 'API\AssetInventoryController']);
// ===============================================End For Assets Inventory ICS==========================
// ===============================================For IRRUP==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/disposal', function (Request $request) {
    return $request->disposal();
});
// router for Asset Controller
Route::apiResources(['disposal' => 'API\DisposalController']);
// ===============================================End For IRRUP==========================



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



