<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Offer::class, function (Faker $faker) {
    return [
        'author_id' => User::all()->random()->ID,
        'title' => $faker->text(40),
        'body' => $faker->text(300),
        'image' => $faker->imageUrl(640, 480)
    ];
});
