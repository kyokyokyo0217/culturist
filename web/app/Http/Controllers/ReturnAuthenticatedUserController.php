<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\ProfilePicture;
use App\Http\Resources\AuthenticatedUserResource;

class ReturnAuthenticatedUserController extends Controller
{
  public function returnAuthenticatedUser ()
  {
    // profile_pictureの有無でリレーションをロードするか分岐
    // optional()もあり？

    // if (Auth::check()) {
    //   if(ProfilePicture::firstWhere('user_id', Auth::id())){
    //       return Auth::user()->load('profile_picture');
    //   }else{
    //       return Auth::user();
    //   }
    // }

    if (Auth::check()) {
      if(ProfilePicture::firstWhere('user_id', Auth::id())){
          return new AuthenticatedUserResource(Auth::user()->load('profile_picture'));
      }else{
          return new AuthenticatedUserResource(Auth::user());
      }
    }
  }

}
