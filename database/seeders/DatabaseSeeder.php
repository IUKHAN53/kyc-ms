<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = ['admin', 'supervisor', 'auditor', 'user'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 3; $i++) {
                User::create([
                    'name' => ucfirst($role).' User '.$i,
                    'email' => $role.$i.'@example.com',
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]);
            }
        }
    }
}
