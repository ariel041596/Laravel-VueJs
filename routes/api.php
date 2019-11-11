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
// ===============================================For Property Officers==========================
// Middleware to get user
Route::middleware('auth:api')->get('/property_officer', function (Request $request) {
    return $request->property_officer();
});
// router for Usercontroller
Route::apiResources(['property_officer' => 'API\PropertyOfficerController']);
// ===============================================End For Property Officers==========================
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
// ===============================================For Article category==========================
// Middleware to get user
Route::middleware('auth:api')->get('/article_category', function (Request $request) {
    return $request->article_category();
});
// router for Usercontroller
Route::apiResources(['article_category' => 'API\ArticleCategoryController']);
// ===============================================End For Article category==========================
// ===============================================For Total Entries==========================
// Middleware to get user
Route::middleware('auth:api')->get('/total_assets', function (Request $request) {
    return $request->total_assets();
});
// router for Usercontroller
Route::apiResources(['total_assets' => 'API\TotalEntriesController']);
// ===============================================End For Total Entries==========================
// ===============================================For Total Entries==========================
// Middleware to get user
Route::middleware('auth:api')->get('/total_inventories', function (Request $request) {
    return $request->total_inventories();
});
// router for Usercontroller
Route::apiResources(['total_inventories' => 'API\TotalInvetoriesController']);
// ===============================================End For Total Entries==========================
// ===============================================For Total items for Disposal==========================
// Middleware to get user
Route::middleware('auth:api')->get('/total_disposal', function (Request $request) {
    return $request->total_disposal();
});
// router for Usercontroller
Route::apiResources(['total_disposal' => 'API\TotalForDisposalController']);
// ===============================================End For Total Total items for Disposal==========================
// ===============================================Get all Approved Transfers==========================
// Middleware to get user
Route::middleware('auth:api')->get('/approved_transfer', function (Request $request) {
    return $request->approved_transfer();
});
// router for Usercontroller
Route::apiResources(['approved_transfer' => 'API\ApprovedTransferController']);
// ===============================================End For Approved Transfers==========================


// ===============================================For Assets==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/asset', function (Request $request) {
    return $request->asset();
});
// router for Asset Controller
Route::apiResources(['asset' => 'API\AssetController']);
// Route::middleware('auth:api')->get('/asset/par/{id}', function (Request $request) { //this is not working
//     return $request->asset(); //this is not working
// });                            //this is not working
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
// Middleware to get Asset of Request for Property
Route::middleware('auth:api')->get('/requests', function (Request $request) {
    return $request->requests();
});
// router for Asset Controller of an employee
Route::apiResources(['requests' => 'API\RequestPropertyController']);

// ===============================================For Assets Request for Property==========================
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
// ===============================================For return request==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/return-request', function (Request $request) {
    return $request->return-request();
});
// router for Asset Controller
Route::apiResources(['return-request' => 'API\ReturnRequestController']);
// ===============================================End For return request==========================
// ===============================================For Re-issue Controller==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/re-issue', function (Request $request) {
    return $request->re_issue();
});
// router for Asset Controller
Route::apiResources(['re-issue' => 'API\ForReIssueController']);
// ===============================================For Transfer Controller==========================
// Middleware to get Asset
Route::middleware('auth:api')->get('/transfer', function (Request $request) {
    return $request->transfer();
});
// router for Asset Controller
Route::apiResources(['transfer' => 'API\ForTransferController']);
// ===============================================End Re-issue Controller==========================
// ===============================================For PAR Printing==========================
// Middleware to get Asset
// Route::middleware('auth:api')->get('/par', function (Request $request) {
//     return $request->par();
// });
// // router for Asset Controller
// Route::apiResources(['par' => 'API\PrintAssetController']);
// ===============================================End For PAR Printing==========================



// ===============================================For Account Code==========================
// Middleware to get Account Code
Route::middleware('auth:api')->get('/accountcode', function (Request $request) {
    return $request->accountcode();
});
// router for Account Code Controller
Route::apiResources(['accountcode' => 'API\AccountCodeController']);
// ===============================================End For Account Code==========================

// ===============================================For Importing Data==========================
// Middleware to [functions] to get/post import data
Route::middleware('auth:api')->get('/import_data', function (Request $request) {
    return $request->import_data();
});
// router for Import Data Controller
Route::apiResources(['import_data' => 'API\ImportDataController']);
// ===============================================End For Importing Data==========================

// ===============================================For Importing Data==========================
// Middleware to [functions] to get/post import data
Route::middleware('auth:api')->get('/dashboard', function (Request $request) {
    return $request->dashboard();
});
// router for Import Data Controller
Route::apiResources(['dashboard' => 'API\DashboardController']);
// ===============================================End For Importing Data==========================

// Router to get the data of the certain id
// Route::get('asset', 'API\AssetController');
// Route::get('/api/asset', 'API\AssetController@index');
// Router for the public profile
// Route::get('{id}', 'API\AssetController@show');

// Pending Asset Search
Route::get('findPending', 'API\AssetPendingController@search');
// End for Pending asset search

// Asset Search
Route::get('findAsset', 'API\AssetController@search');
// End for asset search

// inventory Search
Route::get('findInventory', 'API\AssetInventoryController@search');
// End for inventory search

// Disposal Search
Route::get('findDisposal', 'API\DisposalController@search');
// End for Disposal search

// Request property to supply Search
Route::get('findRequest', 'API\RequestPropertyController@search');
// End for Request property to supply search

// Return request Search
Route::get('findRequestReturn', 'API\ReturnRequestController@search');
// End for Return Request Search

// Transfer request Search
Route::get('findRequestTransfer', 'API\ForTransferController@search');
// End for Transfer Request Search

// Reissue request Search
Route::get('findForReissue', 'API\ForReIssueController@search');
// End for Reissue Request Search

// Reissue request Search
Route::get('findApprovedTransfer', 'API\ApprovedTransferController@search');
// End for Reissue Request Search

// Route::get(':id', 'API\AssetController@show');
// Route::get(':id', 'API\PrintAssetController@show');
Route::get('profile', 'API\UserController@profile');
// Router for the search function
Route::get('findUser', 'API\UserController@search');
// send to User Controller
Route::put('profile', 'API\UserController@updateProfile');


// Route::get('{id}', 'API\PrintAssetController@edit');
// Route::group(['middleware' => 'auth:api'], function ($router) {
//     Route::get('asset/{id}', 'API\PrintAssetController@edit');

// });

// Route::get('add','CarController@create');
// Route::post('add','CarController@store');
// Route::get('car','CarController@index');
// Route::get('edit/{id}','CarController@edit');
// Route::post('edit/{id}','CarController@update');
// Route::delete('{id}','CarController@destroy');



