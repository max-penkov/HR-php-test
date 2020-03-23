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

Route::get('/', 'Order\OrderController@newest');

Route::group([
    'namespace' => 'Order',
    'prefix'    => 'orders',
    'as'        => 'order.',
], function () {
    // Products
    Route::get('/products', 'ProductController@index')->name('products');
    Route::patch('/products/{orderProduct}', 'ProductController@update')->name('products.update');

    // Orders
    Route::get('/newest', 'OrderController@newest')->name('newest');
    Route::get('/overtaken', 'OrderController@overtaken')->name('overtaken');
    Route::get('/current', 'OrderController@current')->name('current');
    Route::get('/completed', 'OrderController@completed')->name('completed');
    Route::get('/{order}', 'OrderController@view')->name('view');
    Route::patch('/{order}', 'OrderController@update')->name('update');
});

//Weather
Route::get('/weather', 'WeatherController@index')->name('weather');

