<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Please enter your email address:');

        $user = User::find(['email' => $email]);

        if ($user->isNotEmpty()) {
            $this->error('User with email founded please reset password on site!');
            die();
        }

        $password = $this->secret('Please enter password:');

        $isAdmin = false;

        if ($this->confirm('Is admin user?')) {
            $isAdmin = true;
        }

        if ($this->confirm('Do you wish to create a new user?')) {
            User::create(['email' => $email, 'name' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'admin' => $isAdmin]);
        }
    }
}
