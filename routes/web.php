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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

//Home page --- Cash In & Cash Out
Route::get('/home', 'HomeController@index')->name('home');
//Cash In
Route::get('/in', function () {
    return view('in');
});
Route::post('/transaction', 'transactionController@store');
Route::get('/in', 'HomeController@amount');
Route::post('/in', 'HomeController@store');
//Cash Out
Route::get('/out', function () {
    return view('out');
});