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
Route::get('/admin/dashboard/{id}', 'DashboardController@GetIpCC');
Route::get('/admin/histogram', 'HistogramController@index');
Route::get('/admin/histogram/{id}/{time?}', 'HistogramController@show');
Route::get('/admin/histogram/camaras/{id}/{time?}', 'HistogramController@showByCamaras');
Route::get('/admin/histogram/video/{id}/{time?}', 'HistogramController@showByVideo');
Route::get('/admin/noc/{id}', 'NocController@show');
Route::post('/admin/noc', 'NocController@update');
// Dashboard reports consolidated
Route::get('/admin/consolidated', 'ConsolidatedController@index');
Route::get('/admin/consolidated/GetLogChannels', 'ConsolidatedController@GetLogChannels');
Route::get('/admin/consolidated/GetLogChannelsByDates/{start}/{end}', 'ConsolidatedController@GetLogChannelsByDates');
// Dashboard reports use of app
Route::get('/admin/useofapp', 'UseOfAppController@index');
Route::get('/admin/useofapp/GetLogUse', 'UseOfAppController@GetLogUse');
Route::get('/admin/useofapp/GetLogChannelsByDates/{start}/{end}', 'UseOfAppController@GetLogUseByDates');
