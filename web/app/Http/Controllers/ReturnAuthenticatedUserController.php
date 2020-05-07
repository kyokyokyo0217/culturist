<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\ProfilePicture;

class ReturnAuthenticatedUserController extends Controller
{
  public function returnAuthenticatedUser ()
  {
    // if (Auth::check()) {
    //   if(!Auth::user()->profile_picture->where('user_id', Auth::id())->isEmpty()){
    //       return Auth::user()->load('profile_picture');
    //   }else{
    //       return Auth::user();
    //   }
    // }

    if (Auth::check()) {
      if(ProfilePicture::firstWhere('user_id', Auth::id())){
          return Auth::user()->load('profile_picture');
      }else{
          return Auth::user();
      }
    }
    // optional()もあり？
    // return Auth::user()->load('profile_picture');
  }

}
