<?php

use Faker\Generator as Faker;

$factory->define(App\Cast::class, function (Faker $faker) {
    return [
        "user_id" => function () {
            return factory(\App\User::class)->create()->id;
        },
        "game_id" => function () {
            return factory(\App\Game::class)->create()->id;
        },
        "point_id" => DB::table('points')->get()->random()->id
    ];
});
