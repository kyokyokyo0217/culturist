<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\ProfilePicture;

$factory->define(ProfilePicture::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'filename' => Str::random(12) . '.jpeg',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
