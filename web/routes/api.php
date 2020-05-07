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

Route::apiResource('pictures', 'PictureController');
Route::apiResource('tracks', 'TrackController');
Route::apiResource('artworks', 'ArtworkController');
Route::apiResource('users', 'UserController');

// Route::put('/user-profiles/{user:user_name}', 'UserProfileController@update');
// Route::get('/user/{user:user_name}', function (App\User $user) {return $user;})->name('user');

Route::get('/auth/user', 'ReturnAuthenticatedUserController@returnAuthenticatedUser')->name('auth.user');
