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
    return view('auth.login');
});

Auth::routes();
//admin
Route::group(['prefix' => 'admin','middleware' => 'auth'],function (){

    Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);
    Route::resource('/users','Admin\UsersController');
    Route::resource('/preworks','Admin\PreWorkController');
    Route::post('/preworks/attr-val','Admin\PreWorkController@getVal');
});

/*Route::get('/home', 'HomeController@index')->name('home');*/
