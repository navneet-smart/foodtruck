<?php

use App\Model\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\Comment::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'post_id' => Post::all()->random()->id,
        'comment' => $faker->sentence(5),
    ];
});
