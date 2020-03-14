<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;
use Pearl\AadhaarValidator\AadhaarValidator;

$adhaar =  new AadhaarValidator();

$factory->define(Student::class, function (Faker $faker) use ($adhaar) {
    $ad = $faker->numerify('##########');
    return [
        'prefix' => $faker->randomElement(\App\Constants::PREFIXES),
        'first_name' => $faker->firstName,
        'middle_name' => $faker->optional()->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(\App\Constants::GENDER),
        'caste' => $faker->randomElement(\App\Constants::CASTE),
        'caste_category' => $faker->randomElement(\App\Constants::CASTE_CATEGORY),
        'religion' => $faker->randomElement(\App\Constants::RELIGIONS),
        'blood_group' => $faker->randomElement(\App\Constants::BLOOD_GROUP),
        'aadhaar_no' => $ad."".$adhaar->checkSum($ad),
        'passport_no' => $faker->numerify('##########'),
    ];
});
