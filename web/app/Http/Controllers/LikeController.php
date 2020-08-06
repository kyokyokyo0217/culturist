<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function likePicture(Request $request, Picture $picture)
    {

        if (!$picture) {
            abort(404);
        }

        $picture->picture_liked_by()->detach(Auth::id());
        $picture->picture_liked_by()->attach(Auth::id());

        return response('', 201);
    }

    public function unlikePicture(Request $request, Picture $picture)
    {
        if (!$picture) {
            abort(404);
        }

        $picture->picture_liked_by()->detach(Auth::id());

        return response('', 204);
    }

    public function likeTrack(Request $request, Track $track)
    {

        if (!$track) {
            abort(404);
        }

        $track->track_liked_by()->detach(Auth::id());
        $track->track_liked_by()->attach(Auth::id());

        return response('', 201);
    }

    public function unlikeTrack(Request $request, Track $track)
    {
        if (!$track) {
            abort(404);
        }

        $track->track_liked_by()->detach(Auth::id());

        return response('', 204);
    }
}
