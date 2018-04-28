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
    return view('home');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'UserRolesAdminController@index')->name('userrolesadmin');
Route::get('/admin/{user}', 'UserRolesAdminController@show');
Route::post('/admin/{user}', 'UserRolesAdminController@store');

Route::get('/cards', 'CardController@index');
Route::get('/cards/create','CardController@newCard');
Route::get('/cards/{card}', 'CardController@show');
Route::patch('/cards/{card}', 'CardController@store');
Route::post('/cards', 'CardController@create');
Route::delete('/cards/{card}','CardController@destroy');

Route::get('/my_cards', 'CardController@showUserCards');
Route::delete('/my_cards/{card}/detach', 'CardController@detachUserCard');

Route::get('/my_orders', 'OrderController@index');
Route::get('/my_orders/create', 'OrderController@create');
Route::post('/my_orders', 'OrderController@store');

Route::get('/orders', 'OrderController@indexAll');
Route::post('/orders/{order}/reject', 'OrderController@reject');
Route::post('/orders/{order}/approve', 'OrderController@approve');

Route::get('/statistics', 'StatisticsController@index');
Route::get('/statistics/{user}', 'StatisticsController@show');

Route::get('/my_statistics', 'StatisticsController@index_my');
