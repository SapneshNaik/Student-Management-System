<?php

use Illuminate\Database\Seeder;

class StudentParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        factory(App\Models\User::class, 200)->create([
            'base_role' => \App\Constants::BASE_ROLE[3]
        ])->each(function ($parentUser) {

            $parentUser->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[0]]
            ));

            $parentUser->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[1]]
            ));

            factory(App\Models\StudentParent::class, 1)->create([
                'user_id' => $parentUser->id
            ])->each(function ($parentProfile)
            use ($parentUser) {
                factory(App\Models\User::class, rand(1,3))->create([
                    'base_role' => \App\Constants::BASE_ROLE[2]
                ])->each(function ($studentUser) use ($parentUser) {
                    $studentUser->addresses()->save(factory(App\Models\Address::class)->make(
                        ['type' => \App\Constants::ADDRESS_TYPES[0]]
                    ));

                    $studentUser->addresses()->save(factory(App\Models\Address::class)->make(
                        ['type' => \App\Constants::ADDRESS_TYPES[1]]
                    ));

                    $studentUser->student()->save(factory(App\Models\Student::class)->make(
                        ['parent_id' => $parentUser->id]
                    ));
                });
            });

        });


    }
}
