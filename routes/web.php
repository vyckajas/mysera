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


Route::get('/all-transactions-csv', function(){

    $table = \App\Transaction::all();
    $filename = "transactions.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('Transaction_ID', 'User_ID', 'Operation_Amount', 'Taxes', 'Currency', 'Operation'));

    foreach($table as $row) {
        fputcsv($handle, array($row['id'], $row['user_id'], $row['amount'], $row['tax'], $row['currency'], $row['operation']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );

    return Response::download($filename, 'transactions.csv', $headers);
});


///////// Neaišku ar reikalingi
Route::get('/in', 'HomeController@amount');
Route::post('/in', 'HomeController@store');
