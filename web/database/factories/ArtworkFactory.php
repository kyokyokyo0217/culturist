<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Artwork;

$factory->define(App\Artwork::class, function (Faker $faker) {
    return [
      'id' => Str::random(12),
      'track_id' => fn() => factory(App\Track::class)->create()->id,
      'filename' => Str::random(12) . '.jpeg',
      'created_at' => $faker->dateTime(),
      'updated_at' => $faker->dateTime(),
    ];
});
