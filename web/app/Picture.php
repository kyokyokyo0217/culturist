<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use Illuminate\Support\Facades\Auth;

class Picture extends Model
{
  use StringKey;

  protected $keyType = 'string';

  const ID_LENGTH = 12;

  protected $appends = [
      'url', 'liked_by_user'
  ];

  protected $visible = [
      'id', 'artist', 'url', 'title', 'liked_by_user'
  ];

  public function getUrlAttribute()
  {
      return Storage::cloud()->url($this->attributes['filename']);
  }

  public function getLikedByUserAttribute()
  {
      if (Auth::guest()) {
          return false;
      }

      return $this->picture_liked_by->contains(function ($user) {
          return $user->id === Auth::user()->id;
      });
  }

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    if (! Arr::get($this->attributes, 'id')) {
        $this->setStringId($attributes);
    }
  }

  public function artist()
  {
      return $this->belongsTo('App\User', 'user_id', 'id', 'users');
  }

  public function picture_liked_by()
  {
    return $this->belongsToMany('App\User', 'picture_likes', 'picture_id', 'user_id')->withTimestamps();
  }
}
