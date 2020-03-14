<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Staff;
use Faker\Generator as Faker;
use Pearl\AadhaarValidator\AadhaarValidator;

$adhaar =  new AadhaarValidator();

$factory->define(Staff::class, function (Faker $faker) use ($adhaar) {

    $ad = $faker->numerify('##########');
    return [
        'prefix' => $faker->randomElement(\App\Constants::PREFIXES),
        'first_name' => $faker->firstName,
        'middle_name' => $faker->optional()->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(\App\Constants::GENDER),
        'aadhaar_no' => $ad."".$adhaar->checkSum($ad),
        'passport_no' => $faker->numerify('##########'),
    ];
});
