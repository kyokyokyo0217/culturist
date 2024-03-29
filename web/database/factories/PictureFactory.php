<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Picture;

$factory->define(Picture::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'filename' => Str::random(12) . '.jpg',
        'title' => $faker->name,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
