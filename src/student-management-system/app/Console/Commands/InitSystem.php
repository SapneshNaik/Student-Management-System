<?php

namespace App\Console\Commands;

use App\Constants;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InitSystem extends Command
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
    protected $description = 'Initial Student Management System';

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
     * @return mixed
     */
    public function handle()
    {

        $super_admin = Role::updateOrCreate(['name' => Constants::ROLES['SUPER_ADMIN'], 'guard_name' => 'api']);
        $this->info("Created Super Admin Role");

        $admin = Role::updateOrCreate(['name' => Constants::ROLES['ADMIN'], 'guard_name' => 'api']);
        $this->info("Created Admin Role");

        $nonTeachingStaff = Role::updateOrCreate(['name' => Constants::ROLES['NON_TEACHING_STAFF'],
            'guard_name' => 'api']);
        $this->info("Created Non Teaching Staff Role");

        $teachingStaff = Role::updateOrCreate(['name' => Constants::ROLES['TEACHING_STAFF'], 'guard_name' => 'api']);
        $this->info("Created Teaching Staff Role");

        $registerStudentsPerm = Permission::updateOrCreate(['name' => Constants::PERMISSIONS['REGISTER_STUDENT'],
            'guard_name' => 'api']);
        $this->info("Created Register Students Permission");

        $registerStaffPerm = Permission::updateOrCreate(['name' => Constants::PERMISSIONS['REGISTER_STAFF'],
            'guard_name' => 'api']);
        $this->info("Created Register Staff Permission");

        $registerAdminPerm = Permission::updateOrCreate(['name' => Constants::PERMISSIONS['REGISTER_ADMIN'],
            'guard_name' => 'api']);
        $this->info("Created Register Admin Permission");

        $registerStudentsPerm->syncRoles([$admin]);

        $admin->givePermissionTo($registerStaffPerm);

        $this->info("Setup Complete");
    }
}
