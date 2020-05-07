<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;

class Track extends Model
{
  use StringKey;

  protected $keyType = 'string';

  public $incrementing = false;

  const ID_LENGTH = 12;

  protected $appends = [
      'url',
  ];

  protected $visible = [
      'id', 'artist', 'url', 'title', 'artwork'
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    if (! Arr::get($this->attributes, 'id')) {
        $this->setStringId($attributes);
    }
  }

  public function getUrlAttribute()
  {
      return Storage::cloud()->url($this->attributes['filename']);
  }

  public function artwork()
  {
    return $this->hasOne('App\Artwork', 'track_id', 'id');
  }

  public function artist()
  {
    return $this->belongsTo('App\User', 'user_id', 'id', 'users');
  }
}
