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

Route::get('/admin/lprMaps','lprMapsController@index');
Route::get('/admin/Records','RecordsController@index');
Route::get('/admin/Vids','VidsController@index');
Route::get('/admin/calls','CallsController@index');
Route::get('/admin/streaming','StreamingsController@index');

