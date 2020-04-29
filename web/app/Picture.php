<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{
  protected $keyType = 'string';

  const ID_LENGTH = 12;

  protected $appends = [
      'url',
  ];

  protected $visible = [
      'id', 'artist', 'url',
  ];


  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    if (! Arr::get($this->attributes, 'id')) {
        $this->setId();
    }
  }

  private function setId()
  {
      $this->attributes['id'] = $this->getRandomId();
  }

  private function getRandomId()
  {
      $characters = array_merge(
          range(0, 9), range('a', 'z'),
          range('A', 'Z'), ['-', '_']
      );

      $length = count($characters);

      $id = "";

      for ($i = 0; $i < self::ID_LENGTH; $i++) {
          $id .= $characters[random_int(0, $length - 1)];
      }

      return $id;
  }

  public function artist()
  {
      return $this->belongsTo('App\User', 'user_id', 'id', 'users');
  }

  public function getUrlAttribute()
  {
      return Storage::cloud()->url($this->attributes['filename']);
  }

}
