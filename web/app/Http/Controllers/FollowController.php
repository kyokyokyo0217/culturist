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

    public function follow(User $user)
    {
        User::followUser($user);
        return response('', 201);
    }

    public function unfollow(User $user)
    {
        User::unfollowUser($user);
        return response('', 204);
    }
}
