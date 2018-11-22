<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'body' => $faker->text()
    ];
});
