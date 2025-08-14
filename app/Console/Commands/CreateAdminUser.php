<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin-user {name} {email} {password}';

    protected $description = 'Create a new admin user with the given name, email, and password';

    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        try {
            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('Admin user created successfully!');
            $this->info("Name: {$user->name}");
            $this->info("Email: {$user->email}");
        } catch (\Exception $e) {
            $this->error("Failed to create admin user: {$e->getMessage()}");
        }
    }
}
