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





Auth::routes(['middleware' => 'revalidate']);

Route::get('/', array('before' => 'auth', function() {

  if(Auth::user()) {
      return redirect('/admin/preworks/');
  }else{
      return view('auth.login');
  }

}));
//admin
Route::group(['prefix' => 'admin','middleware' => ['auth','revalidate']],function (){



    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });


    Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);
    /* пользователи*/
    Route::resource('/users','Admin\UsersController');
    Route::post('/users-update/{id}/','Admin\UsersController@updateUser')->name('user_update');

    /* Клиенты*/
    Route::post('/clients-search','Admin\ClientController@search')->name('search_name');
    Route::resource('/clients','Admin\ClientController');
    /* Работы*/
    Route::resource('/preworks','Admin\PreWorkController');


    /* получение атрибутов и поиск*/
    Route::post('/preworks/attr-val','Admin\PreWorkController@getVal');
    Route::post('/preworks/edit-attr-val','Admin\PreWorkController@editGetVal');
    /* получение атрибутов и поиск*/
    Route::post('/preworks/attr-val-filter','Admin\PreWorkController@getValFilter');
    Route::get('preworks/attr-val/fetch_data','Admin\PreWorkController@fetch_data');

    /* получение атрибутов и поиск*/
    Route::post('/preworks/search-val','Admin\PreWorkController@searchVal');
    Route::post('/preworks/filter-search-val','Admin\PreWorkController@filterSearchVal');
    Route::post('/preworks/create-search-val','Admin\PreWorkController@createSearchVal');

    /* фильтры*/
    Route::POST('preworks/add-filter','Admin\PreWorkController@addFilter');
    Route::POST('preworks/filter-form','Admin\PreWorkController@storeFilter')->name('filter_form');


    /* получение атрибутов работы*/
    Route::post('preworks/get-items','Admin\PreWorkController@getAttr');


    /* работы,отчеты о выполненых*/
    Route::post('/preworks-delete/{id}','Admin\PreWorkController@delete')->name('preworks.delete');
    Route::get('/prework-reports/{id}','Admin\PreWorkReportController@all')->name('prework-reports.all');
    Route::get('/prework-report-create/{id}','Admin\PreWorkReportController@create')->name('prework-reports.create');
    Route::post('/prework-report-store/','Admin\PreWorkReportController@store')->name('prework-reports.store');
    Route::get('/prework-report-show/{id}','Admin\PreWorkReportController@show')->name('prework-reports.show');
    Route::get('/prework-report-edit/{id}','Admin\PreWorkReportController@edit')->name('prework-reports.edit');
    Route::post('/prework-report-update','Admin\PreWorkReportController@update')->name('prework-reports.update');


    /* комментарии ajax*/
    Route::resource('comment','Admin\CommentController',['only' =>['store','storeReport']]);
    Route::post('comment-report','Admin\CommentController@storeReport')->name('storeReport');


});

/*Route::get('/home', 'HomeController@index')->name('home');*/
