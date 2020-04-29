<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes();

Route::resource('pictures', 'PictureController');
Route::get('/works', 'WorkController@index')->name('work.index');
Route::post('/works', 'WorkController@create')->name('work.create');
Route::get('/auth/user', function(){return Auth::user();})->name('auth.user');
