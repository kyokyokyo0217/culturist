<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/pictures/feed', 'PictureController@getPicturesFeed');
Route::get('/pictures/likes', 'PictureController@getLikedPictures');
Route::get('/pictures/explore', 'PictureController@getNewPictures');
Route::get('/pictures/user/{user}', 'PictureController@getUserProfilePictures');
Route::apiResource('pictures', 'PictureController');
Route::get('/tracks/feed', 'TrackController@getTracksFeed');
Route::get('/tracks/likes', 'TrackController@getLikedTracks');
Route::get('/tracks/explore', 'TrackController@getNewTracks');
Route::get('/tracks/user/{user}', 'TrackController@getUserProfileTracks');
Route::apiResource('tracks', 'TrackController');
Route::apiResource('artworks', 'ArtworkController');
Route::apiResource('users', 'UserController');

Route::post('/{user}/follow', 'FollowController@follow');
Route::delete('/{user}/follow', 'FollowController@unfollow');

Route::post('/picture/{picture}/like', 'LikeController@likePicture');
Route::delete('/picture/{picture}/like', 'LikeController@unlikePicture');
Route::post('/track/{track}/like', 'LikeController@likeTrack');
Route::delete('/track/{track}/like', 'LikeController@unlikeTrack');

Route::get('/auth/user', 'ReturnAuthenticatedUserController@returnAuthenticatedUser')->name('auth.user');
Route::post('/search', 'SearchController@search');

Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();
    return response()->json();
});
