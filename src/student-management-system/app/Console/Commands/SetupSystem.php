<?php

namespace App\Console\Commands;

use App\Constants;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:setup_system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Setup of Student Management System';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {

        $this->line('------------- Setting Up Roles:');

        foreach (Constants::ROLES as $perm => $value) {
            $role = Role::updateOrCreate(['name' => $value, 'guard_name' => 'api']);
            $this->info("Created " . $role->name . " Role");
        }

        $this->line('------------- Setting Up Permissions:');

        $role = Role::where('name', Constants::ROLES['SUPER_ADMIN'])->first();



        foreach (Constants::PERMISSIONS as $perm => $value) {
            $perm = Permission::updateOrCreate(['name' => $value,
                'guard_name' => 'api']);

            $role->givePermissionTo($perm);

            $this->info("Created " . $perm->name . " Permission");
        }

        $this->info("All permissions are granted to ". Constants::ROLES['SUPER_ADMIN']);
        $this->line('------------- Set Up Complete: \n');
    }
}
