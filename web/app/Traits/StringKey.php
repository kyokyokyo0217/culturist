<?php

namespace App\Traits;

trait StringKey
{
    public function setStringId(array $attributes = [])
    {
        $characters = array_merge(
            range(0, 9),
            range('a', 'z'),
            range('A', 'Z'),
            ['-', '_']
        );

        $current_length = count($characters);

        $id = "";

        for ($i = 0; $i < config('constants.ID_LENGTH'); $i++) {
            $id .= $characters[random_int(0, $current_length - 1)];
        }

        $this->attributes['id'] = $id;
    }
}
