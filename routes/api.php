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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('kategori/store','API\ControllerKategori@store');
Route::post('keluhan/store','API\ControllerKeluhan@store');
Route::get('kategori','API\ControllerKategori@index');;
Route::get('kategori/search/{kategori}', 'API\ControllerKategori@search');
Route::post('keluhan_detail/store','API\ControllerKeluhanDetail@store');
Route::get('keluhan','API\ControllerKeluhan@index');;
Route::get('manajer','API\ControllerManajer@index');
Route::get('surveyor','API\ControllerSurveyor@index');
Route::get('chat/{NIM}','API\ControllerChat@index');
Route::post('manajer/update/{id_keluhan}','API\ControllerManajer@update');
Route::post('users/update/{NIM}','API\UserController@update');
Route::get('users','API\UserController@index');
Route::get('keluhan_detail/{id_keluhan}','API\ControllerKeluhanDetail@index');

//hoho
Route::get('chat/hoho','API\ControllerChat@create');