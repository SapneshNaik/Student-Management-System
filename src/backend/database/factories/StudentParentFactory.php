<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StudentParent;
use Faker\Generator as Faker;

$factory->define(StudentParent::class, function (Faker $faker) {
    $faker->addProvider(new \Bezhanov\Faker\Provider\Demographic($faker));

    $father_alumni = $faker->boolean;
    $mother_alumni = $faker->boolean;

    return [
        'father_full_name' => $faker->name('male'),
        'mother_full_name' => $faker->name('female'),

        'father_qualification' => $faker->randomElement(\App\Constants::QUALIFICATION),
        'mother_qualification' => $faker->randomElement(\App\Constants::QUALIFICATION),

        'father_contact_number' => $faker->numerify('##########'),
        'mother_contact_number' => $faker->optional()->numerify('##########'),


        'father_profession' => $faker->randomElement(\App\Constants::PROFESSION),
        'mother_profession' => $faker->optional()->randomElement(\App\Constants::PROFESSION),

        'father_designation' => $faker->jobTitle,
        'mother_designation' => $faker->optional()->jobTitle,

        'father_net_annual_income' => $faker->numerify('##,##,###'),
        'mother_net_annual_income' => $faker->optional()->numerify('##,##,###'),

        'father_pan' => $faker->regexify("([A-Z]){5}([0-9]){4}([A-Z]){1}"),
        'mother_pan' => $faker->optional()->regexify("([A-Z]){5}([0-9]){4}([A-Z]){1}"),

        'is_father_alumni' => $father_alumni,
        'is_mother_alumni' => $mother_alumni,

        'father_joining_year' => ($father_alumni) ?  $faker->year('1980') : null,
        'mother_joining_year' => ($mother_alumni) ?  $faker->year('1980') : null,

        'father_leaving_year' => ($father_alumni) ?  $faker->year('1990') : null,
        'mother_leaving_year' => ($mother_alumni) ?  $faker->year('1990') : null,


    ];
});
