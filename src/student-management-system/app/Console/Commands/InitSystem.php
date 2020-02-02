<?php

namespace App\Console\Commands;

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

        $super_admin = Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->info("Created Super Admin Role");

        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'api']);
        $this->info("Created Admin Role");

        $nonTeachingStaff = Role::create(['name' => 'Non Teaching Staff', 'guard_name' => 'api']);
        $this->info("Created Non Teaching Staff Role");

        $teachingStaff = Role::create(['name' => 'Teaching Staff', 'guard_name' => 'api']);
        $this->info("Created Teaching Staff Role");

        $registerStudentsPerm = Permission::create(['name' => 'Register Students', 'guard_name' => 'api']);
        $this->info("Created Register Students Permission");

        $registerStudentsPerm->syncRoles([$admin, $nonTeachingStaff]);

        $this->info("Setup Complete");
    }
}
