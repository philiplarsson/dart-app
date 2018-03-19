<?php

use Faker\Generator as Faker;

$factory->define(App\GameType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});
