<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Track;

$factory->define(Track::class, function (Faker $faker) {
    return [
      'id' => Str::random(12),
      'filename' => Str::random(12) . '.mp3',
      'title' => $faker->name,
      'created_at' => $faker->dateTime(),
      'updated_at' => $faker->dateTime(),
    ];
});
