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

Route::GET('list-address', 'AdressBookController@index');

Route::GET('add-address', 'AdressBookController@create');
Route::POST('create-address', 'AdressBookController@store');

Route::GET('edit-address/{slug}', 'AdressBookController@edit');
Route::POST('update-address/{slug}', 'AdressBookController@update');

Route::GET('show-address/{slug}', 'AdressBookController@show');

Route::delete('delete-address/{slug}', 'AdressBookController@destroy');
