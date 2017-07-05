<?php
// Welcome page
Route::get('/', function () {
    return view('welcome');
});
// Admin panel
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
// Authentication
Auth::routes();
//Home page --- Cash In & Cash Out
Route::get('/home', 'HomeController@index')->name('home');
//Cash In
Route::get('/in', function () {
    return view('in');
});
//Cash Out
Route::get('/out', function () {
    return view('out');
});
// Transactions
Route::post('/transaction', 'transactionController@store');



///////// Neaišku ar reikalingi
Route::get('/in', 'HomeController@amount');
Route::post('/in', 'HomeController@store');
