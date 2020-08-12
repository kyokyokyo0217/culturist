<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProfilePicture;
use App\Http\Resources\AuthenticatedUserResource;

class ReturnAuthenticatedUserController extends Controller
{
    public function returnAuthenticatedUser()
    {
        if (Auth::check()) {
            return new AuthenticatedUserResource(Auth::user()->load('profile_picture'));
        }
    }
}
