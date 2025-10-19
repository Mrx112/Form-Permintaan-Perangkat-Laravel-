<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create or update admin user (username: admin, password: admin)
        User::updateOrCreate(
            ['email' => 'devilarm207@gmail.com'],
            [
                'name' => 'admin',
                'email' => 'devilarm207@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'approved' => true,
                'approved_at' => now(),
                'approval_token' => null,
                'email_verified_at' => now(),
            ]
        );

        // create or update normal user (username: user, password: user)
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('user'),
                'role' => 'user',
                'approved' => true,
                'approved_at' => now(),
                'approval_token' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
