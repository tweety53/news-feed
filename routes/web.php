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

Route::get('news', 'Feed\NewsItemController@index')->name('news.index');

Route::get('news/{id}', 'Feed\NewsItemController@view')->name('news.item.view');
