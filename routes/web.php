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



    /* Каталог фронт */
    Route::get('/catalog/{id}','Admin\CatalogController@index')->name('catalog_index');

    /* Каталог админ */
    Route::get('/catalog-menu/{id}/','Admin\CatalogMenuController@index')->name('catalog_menu');

    /*add cat*/
    Route::post('/catalog-add-cat/','Admin\CatalogMenuController@addCat')->name('add_cat');
    Route::post('catalog-store-cat','Admin\CatalogMenuController@storeCat')->name('store_cat');


    /*add series*/
    Route::post('/catalog-add-series','Admin\CatalogMenuController@addSeries')->name('add_series');
    Route::post('/catalog-store-series','Admin\CatalogMenuController@storeSeries')->name('store_series');

    /*add product*/
    Route::get('/catalog-add-product/{id}','Admin\CatalogMenuController@addProduct')->name('add_product');
    Route::post('/catalog-store-product','Admin\CatalogMenuController@storeProduct')->name('store_product');
    Route::get('/product/{id}','Admin\ProductController@showProduct')->name('show_product');

    /*select cat product*/
    Route::post('{id}/catalog-select-product','Admin\CatalogMenuController@selectProduct')->name('select_product');
    /* edit product*/
    Route::get('/edit-product/{id}','Admin\ProductController@editProduct')->name('edit_product');
    Route::post('/update-product','Admin\ProductController@updateProduct')->name('upd_product');

    /* user select cat product*/
    Route::post('/catalog-user-select-product','Admin\CatalogMenuController@userSelectProduct')->name('user_select_product');

    /*index matching*/
    Route::post('/matching-product','Admin\MatchingController@index')->name('matching_product');
    /*save matching*/

    Route::post('/matching-save','Admin\MatchingController@store')->name('matching_store');
    /*select cat matching*/
    Route::post('/matching-catalog-1c','Admin\MatchingController@selectCat1c')->name('select_cat_1c');

    /*delete product*/
    Route::post('/catalog-delete-product','Admin\CatalogMenuController@deleteProduct')->name('del_product');

    /* block attributes */
    Route::get('/block-attr','Admin\BlockAttributeController@index')->name('block_attribute');
    Route::get('/block-attr/{id}','Admin\BlockAttributeController@show')->name('block_attribute_show');
    Route::get('/block-add','Admin\BlockAttributeController@add')->name('add_block');
    Route::post('/block-store','Admin\BlockAttributeController@store')->name('store_block');
    /* end block attributes */

    /* attributes */

    Route::get('/add-attribute/{id}','Admin\AttributeController@add')->name('add_attribute');
    Route::post('/store-attribute/','Admin\AttributeController@store')->name('store_attribute');
    Route::get('/edit-attribute/{id}','Admin\AttributeController@edit')->name('edit_attribute');
    Route::post('/update-attribute/','Admin\AttributeController@update')->name('update_attribute');



    Route::post('/delete-attribute/','Admin\AttributeController@delete')->name('del_attribute');

    /* end attributes */

    /* cat */

    Route::get('/catalog-block','Admin\CatBlockController@index')->name('cat_all');
    Route::get('/show-catalog-block/{id}','Admin\CatBlockController@showCatalog')->name('show_catalog');

    Route::get('/catalog-block-show/{id}','Admin\CatBlockController@show')->name('cat_block_show');
    Route::post('/catalog-block-store','Admin\CatBlockController@store')->name('store_cat_block');

    Route::post('/catalog-delete-cat','Admin\CatalogMenuController@deleteCat')->name('del_cat');

    /*delete series*/

    Route::post('/catalog-delete-series','Admin\CatalogMenuController@deleteSeries')->name('del_series');


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
