<?php

namespace App\Console\Commands;

use App\Constants;
use App\Http\Validators\RequestValidators;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;
use Mockery\Exception;


class GenerateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:super_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Super Admin for Student Management System';

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

        $login_id = $this->ask('What is Super Admin login_id?');
        $email = $this->ask('What is Super Admin email?');
        $phone_number = $this->ask('What is Super Admin phone number?');
        $password = $this->secret('What is Super Admin password (min: 6 digits)?');
        $password_confirmation = $this->secret('Confirm Super Admin password:');
        $base_role = 'Admin';

        $prefix = $this->choice('What is Super Admin prefix?', Constants::PREFIXES, 0);
        $first_name = $this->ask('What is Super Admin first name?');
        $last_name = $this->ask('What is Super Admin last name?');
        $is_super_admin = true;

        $user_input = compact(['login_id',
            'email',
            'phone_number',
            'password',
            'password_confirmation',
            'base_role']);


        $userValidator = RequestValidators::userValidator($user_input, true);

        if ($userValidator->fails()) {
            $this->printValidationErrors($userValidator);
            $this->error("Super Admin Creation Failed!!");
            return;
        }

        $user_input['password'] = bcrypt($password);

        $user = User::create($user_input);
        $user->setStatus('Active');

        $user_id = $user->id;

        //TODO: add login_id and phone number validation [PARTIAL]
        $admin_input = compact(['prefix',
            'first_name',
            'last_name',
            'is_super_admin',
            'user_id']);

        $adminValidator = RequestValidators::adminValidator($admin_input);

        if ($adminValidator->fails()) {
            $this->printValidationErrors($adminValidator);
            $this->error("Super Admin Creation Failed!!");
            $user->forceDelete();
            return;
        }

        try {
            $admin = Admin::create($admin_input);
            $user->assignRole('Super Admin');

        } catch (Exception $e){
            $user->forceDelete();
        }


        $this->info('Super Admin Created!');

    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $userValidator
     */
    public function printValidationErrors(\Illuminate\Contracts\Validation\Validator $userValidator): void
    {
        foreach ($userValidator->errors()->getMessages() as $error) {
            if (is_array($error)) {
                foreach ($error as $e):
                    $this->error($e);
                endforeach;
            } else {
                $this->error($error);
            }
        }
    }

}
