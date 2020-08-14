<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Picture;
use App\Models\Track;
use App\Http\Requests\Search;
use App\Http\Resources\UserResource;
use App\Http\Resources\PictureResource;
use App\Http\Resources\TrackResource;

class SearchController extends Controller
{
    public function search(Search $request)
    {
        $keyword = $request->input('keyword');

        $users = User::searchUsers($keyword);
        $pictures = Picture::searchPictures($keyword);
        $tracks = Track::searchTracks($keyword);

        return response()->json([
            'users' => UserResource::collection($users),
            'pictures' => PictureResource::collection($pictures),
            'tracks' => TrackResource::collection($tracks)
        ]);
    }
}
