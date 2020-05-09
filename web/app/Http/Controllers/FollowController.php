<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    public function follow(Request $request, User $user)
    {
      Auth::user()->follows()->detach($user->id);
      Auth::user()->follows()->attach($user->id);

      return response('', 201);
    }

    public function unfollow(Request $request, User $user)
    {
      Auth::user()->follows()->detach($user->id);

      return response('', 204);
    }
}
