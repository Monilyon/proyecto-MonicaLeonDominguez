<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'a1@admin.com',
            'password' => Hash::make('admin'),
            'rol' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
