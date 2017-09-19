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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/payu/response', 'HomeController@response');
//Route::get('/payu/confirmation', 'HomeController@confirmation');

//Route::post('/payu/response', 'HomeController@response');
Route::post('/payu/confirmation', 'HomeController@confirmation');
