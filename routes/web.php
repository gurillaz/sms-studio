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

use App\Client;

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('download/{filename}', 'FileController@downloadFile')
    ->where('filename', '[A-Za-z0-9\-\_\.]+')
    ->name('file.download');


// Route everything else to Vue
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');



/*Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::resource('client','ClientController');
//    Route::delete('client/ajax/{clientId}','ClientController@destroyAjax');





    Route::resource('employee','EmployeeController');


    Route::resource('job','JobController');
(
    Route::get('job/create/{part_no}','JobController@CreatePart');


    Route::post('job/create/1','JobController@PostCreatePart1');
    Route::post('job/create/2/new','JobController@PostCreatePart2NewClient');
    Route::post('job/create/2/existing','JobController@PostCreatePart2ExistingClient');
    Route::post('job/create/3','JobController@PostCreatePart3');
    Route::post('job/addEvent','JobController@addEventAjax');
    Route::post('job/create/4','JobController@PostCreatePart4');




    Route::get('job/event/part/{event_no}','JobController@addFormEventPart');






    Route::resource('event','EventController');



    Route::resource('note','NoteController');

    Route::resource('offer','OfferController');
    Route::resource('service','ServiceController');
    Route::resource('inventory','InventoryController');


    Route::resource('file','FileController');
    Route::get('download/{filename}','FileController@download')
        ->where('filename', '[A-Za-z0-9\-\_\.]+')
        ->name('file.download');





//    Route::post('ajax/clients','ajaxController@clientsJson');
    Route::get('/', 'HomeController@index')->name('home');
});



Auth::routes();*/
