<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Picture;
use App\Track;

class SearchController extends Controller
{
  public function search(Request $request){

    if($request->has('keyword')){
      $keyword = $request->input('keyword');

      $users = User::with(['profile_picture'])->where('name', 'like', '%'.$keyword.'%')->orWhere('user_name', 'like', '%'.$keyword.'%')->get();
      $pictures = Picture::with(['artist', 'artist.profile_picture'])->where('title', 'like', '%'.$keyword.'%')->get();
      $tracks = Track::with(['artist', 'artwork'])->where('title', 'like', '%'.$keyword.'%')->get();

      return response()->json([
        'users'=> $users,
        'pictures' => $pictures,
        'tracks' => $tracks
      ]);
    }
  }
}
