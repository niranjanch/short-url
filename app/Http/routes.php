<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['web']], function () {

    Route::get('/', [
        'as'   => 'home',
        'uses' => 'LinksController@index'
    ]);

    Route::get('/{hash}', [
       'as' => 'hash',
       'uses' => 'LinksController@redirect'
    ]);

    Route::post('save', [
        'as'   => 'save',
        'uses' => 'LinksController@saveLink'
    ]);

});