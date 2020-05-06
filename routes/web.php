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
    return redirect(route('voyager.login'));
});

//Route::get('/admin/achats','AchatController@index');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    /*-- Achat --*/
    Route::get('achats', ['uses' => 'AchatController@index', 'as' => 'index_achats']);
    Route::get('achats/create', ['uses' => 'AchatController@create', 'as' => 'create_achats']);
    Route::post('achats', ['uses' => 'AchatController@store', 'as' => 'store_achats']);
    Route::get('achats/invoice/{achat_id}', ['uses' => 'AchatController@invoice', 'as' => 'invoice_achats']);
    Route::delete('achats/{achat_id}', ['uses' => 'AchatController@destroy', 'as' => 'destroy_achats']);
    /*-- Vente --*/
    Route::get('ventes', ['uses' => 'VenteController@index', 'as' => 'index_ventes']);
    Route::get('ventes/create', ['uses' => 'VenteController@create', 'as' => 'create_ventes']);
    Route::post('ventes', ['uses' => 'VenteController@store', 'as' => 'store_ventes']);
    Route::get('ventes/invoice/{vente_id}', ['uses' => 'VenteController@invoice', 'as' => 'invoice_ventes']);
    Route::delete('ventes/{achat_id}', ['uses' => 'VenteController@destroy', 'as' => 'destroy_ventes']);
    Route::post('checkQteStock', ['uses' => 'VenteController@checkQteStock', 'as' => 'checkQteStock']);
    /*-- Out Products --*/
    Route::get('outProducts', ['uses' => 'AchatController@outProducts', 'as' => 'out_products']);
});
