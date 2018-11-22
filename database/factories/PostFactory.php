<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\Post::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'title' => $faker->sentence(10),
        'content' => $faker->paragraph,
        'published' => rand(0, 1)
    ];
});
