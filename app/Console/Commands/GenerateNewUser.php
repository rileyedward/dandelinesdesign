<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateNewUser extends Command
{
    protected $signature = 'app:generate-new-user {username} {password}';

    protected $description = 'Generate a new user with username and password';

    public function handle(): void
    {
        $username = $this->argument('username');
        $password = bcrypt($this->argument('password'));

        User::create([
            'name' => $username,
            'password' => $password,
        ]);

        $this->info('User created successfully!');
    }
}
