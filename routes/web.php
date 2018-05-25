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

Route::get('chat/hoho/{NIM}','API\ControllerChat@create');
Route::get('chat/detail/{Nama}/{Penerima}','API\ControllerChat@store');
Route::post('rating','API\ControllerChat@edit');
Route::post('chat','API\ControllerChat@show');
Route::get('rating/{id}','API\ControllerChat@update');