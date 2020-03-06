<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        //
        'prefix' => $faker->randomElement(\App\Constants::PREFIXES),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
    ];
});
