<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;
use App\Track;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likePicture(Request $request, Picture $picture)
    {

      // if (! $picture) {
      //     abort(404);
      // }

      $picture->picture_liked_by()->detach(Auth::id());
      $picture->picture_liked_by()->attach(Auth::id());

      return response('', 201);
    }

    public function unlikePicture(Request $request, Picture $picture)
    {
      $picture->picture_liked_by()->detach(Auth::id());
      return response('', 204);
    }

    public function likeTrack(Request $request, Track $track)
    {

      // if (! $picture) {
      //     abort(404);
      // }

      $track->track_liked_by()->detach(Auth::id());
      $track->track_liked_by()->attach(Auth::id());

      return response('', 201);
    }

    public function unlikeTrack(Request $request, Track $track)
    {
      $track->track_liked_by()->detach(Auth::id());
      return response('', 204);
    }
}
