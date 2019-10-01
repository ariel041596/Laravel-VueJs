<?php

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


// this route is for home if not login and has no authorization
// Route::get('/', function () {
//     return view('invoice');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// // Route::get('/path', 'HomeController@index')->where('path','([A-z\d-\/_.]+)?');
Route::get('/{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );

// route for invoice receipt
Route::get('invoice', function(){
    return view('invoice');
});


