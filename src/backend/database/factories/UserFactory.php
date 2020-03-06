<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'login_id' => Str::random(10),
        'email' => $faker->unique()->email,
        'phone_number' => $faker->numerify('##########'),
        'alternate_phone_number' => $faker->numerify('##########'),
        'password' => bcrypt("qwerty"), // password
        'status' => "Active",
    ];
});
