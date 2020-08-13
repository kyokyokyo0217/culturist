<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Picture;
use App\Models\Track;
use App\Http\Requests\Search;


class SearchController extends Controller
{
    public function search(Search $request)
    {
        $keyword = $request->input('keyword');

        $users = User::searchUsers($keyword);
        $pictures = Picture::searchPictures($keyword);
        $tracks = Track::searchTracks($keyword);

        return response()->json([
            'users' => $users,
            'pictures' => $pictures,
            'tracks' => $tracks
        ]);
    }
}
