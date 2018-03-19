<?php

use Faker\Generator as Faker;

$factory->define(App\Game::class, function (Faker $faker) {
    return [
        'game_type_id' => function () {
            return factory(\App\GameType::class)->create()->id;
        }
    ];
});
