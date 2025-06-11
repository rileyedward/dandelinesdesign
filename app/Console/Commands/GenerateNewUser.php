<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateNewUser extends Command
{
    protected $signature = 'app:generate-new-user {username} {password}';

    protected $description = 'Generate a new user with username and password';

    public function handle(): void
    {
        $username = $this->argument('username');
        $password = bcrypt($this->argument('password'));

        User::create([
            'username' => $username,
            'password' => $password,
        ]);

        $this->info('User created successfully!');
    }
}
