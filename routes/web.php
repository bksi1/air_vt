<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'SiteController@index')->name('map');
Route::get('/refresh', 'SiteController@refresh')->name('refresh-map');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sensor', 'SensorController@index')->name('sensor-index');
Route::get('/sensor/create', 'SensorController@create')->name('sensor-create');
Route::post('/sensor/create', 'SensorController@store')->name('sensor-store');
Route::get('/sensor/edit/{id}', 'SensorController@edit')->name('sensor-edit')->where(['id' => '[0-9]+']);
Route::post('/sensor/edit/{id}', 'SensorController@update')->name('sensor-update')->where(['id' => '[0-9]+']);
Route::delete('/sensor/delete/{id}', 'SensorController@destroy')->name('sensor-destroy')->where(['id' => '[0-9]+']);

Route::get('/sensor-type', 'SensorTypeController@index')->name('sensor-type-index');
Route::get('/sensor-type/create', 'SensorTypeController@create')->name('sensor-type-create');
Route::post('/sensor-type/create', 'SensorTypeController@store')->name('sensor-type-store');
Route::get('/sensor-type/edit/{id}', 'SensorTypeController@edit')->name('sensor-type-edit')->where(['id' => '[0-9]+']);
Route::post('/sensor-type/edit/{id}', 'SensorTypeController@update')->name('sensor-type-update')->where(['id' => '[0-9]+']);
Route::delete('/sensor-type/delete/{id}', 'SensorTypeController@destroy')->name('sensor-type-destroy')->where(['id' => '[0-9]+']);

Route::get('/device', 'DeviceController@index')->name('device-index');
Route::get('/device/create', 'DeviceController@create')->name('device-create');
Route::post('/device/create', 'DeviceController@store')->name('device-store');
Route::get('/device/edit/{id}', 'DeviceController@edit')->name('device-edit')->where(['id' => '[0-9]+']);
Route::post('/device/edit/{id}', 'DeviceController@update')->name('device-update')->where(['id' => '[0-9]+']);
Route::delete('/device/delete/{id}', 'DeviceController@destroy')->name('device-destroy')->where(['id' => '[0-9]+']);

Route::post('/api/get-data', 'SensorDataController@getdata')->name('sensor-get-data-post');
Route::get('/api/get-data', 'SensorDataController@getdata')->name('sensor-get-data');
Route::get('/api/gettoken', 'SensorDataController@gettoken')->name('sensor-get-token');
