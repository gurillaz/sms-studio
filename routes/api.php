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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




Route::post('checkAuth', 'api\AuthController@checkAuth');
Route::post('loginAPI', 'api\AuthController@loginPost');

Route::resource('client', 'ClientController');
Route::resource('employee', 'EmployeeController');
Route::resource('offer', 'OfferController');
Route::resource('event', 'EventController');
Route::resource('job', 'JobController');
Route::post('job/addEvents', 'JobController@addEvents');

Route::resource('inventory', 'InventoryController');
Route::resource('note', 'NoteController');
Route::resource('file', 'FileController');
Route::resource('payment', 'PaymentController');

Route::get('checkIfFileExists/{filename}','FileController@checkIfFileExists')
    ->where('filename', '[A-Za-z0-9\-\_\.]+')
    ->name('file.exists');





