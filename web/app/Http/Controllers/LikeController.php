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

    public function likePicture(Picture $picture)
    {
        Picture::likePicture($picture);
        return response('', 201);
    }

    public function unlikePicture(Picture $picture)
    {
        Picture::unlikePicture($picture);
        return response('', 204);
    }

    public function likeTrack(Track $track)
    {
        Track::likeTrack($track);
        return response('', 201);
    }

    public function unlikeTrack(Track $track)
    {
        Track::unlikeTrack($track);
        return response('', 204);
    }
}
