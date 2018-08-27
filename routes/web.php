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

Route::get('/', [
    'uses' => 'AppController@getDashboard',
    'as' => 'dashboard'
]);

Route::post('/get-x-biggest', [
    'uses' => 'AppController@postGetXBiggest',
    'as' => 'x.biggest'
]);

Route::post('/get-x-smallest', [
    'uses' => 'AppController@postGetXSmallest',
    'as' => 'x.smallest'
]);

Route::post('/get-x-fastest', [
    'uses' => 'AppController@postGetXFastest',
    'as' => 'x.fastest'
]);

Route::post('/get-x-slowest', [
    'uses' => 'AppController@postGetXSlowest',
    'as' => 'x.slowest'
]);


