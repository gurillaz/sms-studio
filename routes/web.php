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
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::resource('client','ClientController');
    Route::get('client#deleted_clients_section', "ClientController@deletedSection")->name('client.deleted');

//        'clientController@indexDeleted')->name('clientIndexDeletedSection');




    Route::resource('employee','EmployeeController');
    Route::delete('employee/ajax/{employeeId}','EmployeeController@destroyAjax');



    Route::resource('note','NoteController');
    Route::delete('note/ajax/{noteid}','NoteController@destroyAjax');



    Route::resource('file','FileController');
    Route::get('download/{filename}','FileController@download')
        ->where('filename', '[A-Za-z0-9\-\_\.]+')
        ->name('file.download');





//    Route::post('ajax/clients','ajaxController@clientsJson');
    Route::get('/', 'HomeController@index')->name('home');
});



Auth::routes();


