<?php

namespace App\Traits;

trait LikeSearchScope
{
    public function scopeLikeSearch($query, $keyword, $column)
    {
        return $query->where($column, 'like', '%' . $keyword . '%');
    }
}
