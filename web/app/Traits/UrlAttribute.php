<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UrlAttribute
{
    public function setUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }
}
