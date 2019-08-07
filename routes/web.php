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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::group(['prefix' => 'test'], function () {
    Route::get('/accountkit', ['uses' => 'Test\AccountkitController@index', 'as' => 'index']);
    Route::post('/login', 'Test\AccountkitController@login');
    Route::get('/logout', 'Test\AccountkitController@logout');
    Route::get('/test/{accessToken}/{intervalSec}', 'Test\AccountkitController@test');
});
