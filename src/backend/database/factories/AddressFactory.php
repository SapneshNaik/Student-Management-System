<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        //
        'address' => $faker->address,
        'pin_code' => $faker->numerify('######'),
        'city' => $faker->city,
        'district' => $faker->citySuffix,
        'state' => $faker->state,
        'country' => $faker->country,
    ];
});
