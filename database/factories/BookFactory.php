<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'name' => $faker->text(50),
        'description' => $faker->text(200),
    ];
});
