<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\User::class, 7)->create([
            'base_role' => \App\Constants::BASE_ROLE[0]
        ])->each(function ($user) {
            $user->admin()->save(factory(App\Models\Admin::class)->make());
            $user->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[0]]
            ));
            $user->addresses()->save(factory(App\Models\Address::class)->make(
                ['type' => \App\Constants::ADDRESS_TYPES[1]]
            ));
        });
    }
}

//sudo yum install php74 php74-mbstring php74-xml php74-fpm php74-pdo php74-mysqlnd mysql-server nginx git
