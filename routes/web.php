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

Route::group([
    'namespace' => 'Order',
    'prefix'    => 'orders',
], function () {
    Route::get('/newest', 'OrderController@newest')->name('newest');
    Route::get('/overtaken', 'OrderController@overtaken')->name('overtaken');
});
