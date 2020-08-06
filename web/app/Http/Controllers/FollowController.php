<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }

        Auth::user()->follows()->detach($user->id);
        Auth::user()->follows()->attach($user->id);

        return response('', 201);
    }

    public function unfollow(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }

        Auth::user()->follows()->detach($user->id);

        return response('', 204);
    }
}
