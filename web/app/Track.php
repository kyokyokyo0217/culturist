<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use Illuminate\Support\Facades\Auth;

class Track extends Model
{
    use StringKey;

    protected $keyType = 'string';

    public $incrementing = false;

    const ID_LENGTH = 12;

    protected $appends = [
        'url', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'artist', 'url', 'title', 'artwork', 'liked_by_user'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->track_liked_by->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    public function artwork()
    {
        return $this->hasOne('App\Artwork', 'track_id', 'id');
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }

    public function track_liked_by()
    {
        return $this->belongsToMany('App\Models\User', 'track_likes', 'track_id', 'user_id')->withTimestamps();
    }
}
