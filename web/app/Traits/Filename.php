<?php

namespace App\Traits;

trait Filename
{
    public function getFilename($extension)
    {
        return $this->id . '.' . $extension;
    }
}
