<?php

use Illuminate\Support\Facades\Route;


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
Route::get('/admin/apiconsumo', 'ApiConsumoController@index');
Route::get('/admin/dashboard', 'DashboardController@index');
//Route::get('/admin/histogram', 'HistogramController@index');
//Route::get('/admin/histogram/{id}/{time?}', 'HistogramController@show');
Route::get('/admin/dashboard/{id}/{time?}', 'DashboardController@show');