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

Route::get('cube', 'CubeController@index');
Route::post('cube/create', 'CubeController@create');
Route::post('cube/update', 'CubeController@update');
Route::post('cube/query', 'CubeController@query');

Route::get('standar-cube', 'StandarCubeController@index');
Route::post('standar-cube', 'StandarCubeController@test');