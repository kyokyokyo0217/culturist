<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Artwork extends Model
{
  protected $keyType = 'string';
// primary key 以外にも効いている説
  public $incrementing = false;

  const ID_LENGTH = 12;

  protected $appends = [
      'url',
  ];

  protected $visible = [
      'id', 'url'
  ];

  protected $fillable = [
      'track_id'
  ];

// 共通なのでまとめたい
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

  public function getUrlAttribute()
  {
      return Storage::cloud()->url($this->attributes['filename']);
  }


}
