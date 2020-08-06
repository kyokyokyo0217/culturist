<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;

class Artwork extends Model
{
    use StringKey;

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
}
