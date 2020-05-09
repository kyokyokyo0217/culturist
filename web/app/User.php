<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'user_name', 'email', 'password', 'bio', 'location'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
   protected $visible = [
     'name', 'user_name', 'pictures', 'tracks', 'bio', 'location', 'profile_picture', 'cover_photo', 'followed_by_user'
   ];

    protected $appends = [
      'followed_by_user',
    ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

// route binding のkey変える
  public function getRouteKeyName()
  {
      return 'user_name';
  }

  public function getFollowedByUserAttribute()
  {
      if (Auth::guest()) {
          return false;
      }

      return $this->followers->contains(function ($user) {
          return $user->id === Auth::user()->id;
      });
  }


  public function pictures()
  {
    return $this->hasMany('App\Picture');
  }

  public function tracks()
  {
    return $this->hasMany('App\Track');
  }

  public function profile_picture()
  {
    return $this->hasOne('App\ProfilePicture');
  }

  public function cover_photo()
  {
    return $this->hasOne('App\CoverPhoto');
  }

  public function follows()
  {
    return $this->belongsToMany('App\User', 'follows', 'follow_id', 'follower_id')->withTimestamps();
  }

  public function followers()
  {
    return $this->belongsToMany('App\User', 'follows', 'follower_id', 'follow_id')->withTimestamps();
  }
}
