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

Route::get('/admin/lprMaps', 'lprMapsController@index');
Route::get('/admin/Records', 'RecordsController@index');
Route::get('/admin/Vids', 'VidsController@index');
Route::get('/admin/calls', 'CallsController@index');
Route::get('/admin/streaming', 'StreamingsController@index');
Route::get('/admin/maps', 'MapController@index');
Route::get('/admin/recording', 'GrabacionesController@index');
Route::get('/admin/searchadvanced', 'AdminCameras35Controller@index');
Route::get('/admin/statuscam', 'StatuscamController@index');
Route::get('/admin/alarmstate', 'AdminAlarmStateController@index');
Route::get('/admin/camgrabaciones', 'CamgrabacionesController@index');
