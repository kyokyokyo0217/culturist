<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


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
     'name', 'user_name', 'pictures', 'tracks', 'bio', 'location', 'profile_picture', 'cover_photo'
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
}
