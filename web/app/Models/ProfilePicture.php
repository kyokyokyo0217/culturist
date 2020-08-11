<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;

class ProfilePicture extends Model
{
    use StringKey;
    use UrlAttribute;

    protected $keyType = 'string';

    protected $appends = [
        'url',
    ];

    protected $visible = [
        'id', 'url', 'filename'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    /**
     * Accessor for 'url'
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->setUrlAttribute();
    }
}
