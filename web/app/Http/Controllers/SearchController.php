<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Picture;
use App\Models\Track;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        // requestが空文字のときは自動的にnullに変換される
        $isKeywordValid = $request->has('keyword') && isset($request->keyword);

        if (!$isKeywordValid) {
            abort(404);
        }

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
