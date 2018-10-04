<?php

use Faker\Generator as Faker;
use App\Workspace;

$factory->define(Workspace::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName
    ];
});
