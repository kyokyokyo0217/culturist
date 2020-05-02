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
Route::resource('tracks', 'TrackController');
Route::resource('artworks', 'ArtworkController');
Route::get('/auth/user', function(){return Auth::user();})->name('auth.user');
Route::get('/user/{user:user_name}', function (App\User $user) {return $user;})->name('user');
