<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/employees', 'App\Http\Controllers\EmployeeController@index');
    Route::get('/employees/{departmentTitle}', 'App\Http\Controllers\EmployeeController@index')->where(['departmentTitle' => '\S+']);
    Route::post('/employees', 'App\Http\Controllers\EmployeeController@create');
    Route::post('/employees/import-xml', 'App\Http\Controllers\EmployeeController@importXml');
    Route::put('/employees/{id}', 'App\Http\Controllers\EmployeeController@update')->where(['id' => '\d+']);
    Route::delete('/employees/{id}', 'App\Http\Controllers\EmployeeController@delete')->where(['id' => '\d+']);
});
