<?php

use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 70)->create([
            'base_role' => \App\Constants::BASE_ROLE[1]
        ])->each(function ($user) {
            $user->admin()->save(factory(App\Models\Staff::class)->make());
            $user->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[0]]
            ));
            $user->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[1]]
            ));
        });
    }
}
