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

        $users = User::with(['profile_picture'])
            ->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('user_name', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->where('title', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();
        $tracks = Track::with(['artist', 'artwork'])
            ->where('title', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();

        return response()->json([
            'users' => $users,
            'pictures' => $pictures,
            'tracks' => $tracks
        ]);
    }
}
