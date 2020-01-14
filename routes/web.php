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

Route::group(['middleware'=> 'jwt'], function(){
Route::get('api/employees', 'EmployeesController@index');
Route::get('api/employees/{employee_id}', 'EmployeesController@show');
Route::post('api/employees', 'EmployeesController@store');
Route::patch('api/employees/{employee_id}', 'EmployeesController@update');
Route::delete('api/employees/{employee_id}', 'EmployeesController@destroy');
Route::get('api/employees/{employee_id}/activate', 'EmployeesController@activate');
Route::get('api/employees/{employee_id}/suspend', 'EmployeesController@suspend');
Route::post('api/employees/search', 'EmployeesController@search');
});