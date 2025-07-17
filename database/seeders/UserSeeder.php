<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === 1. Admin ===
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $admin->id,
            'role' => 'admin',
        ]);

        // === 2. Donor ===
        $donor = User::create([
            'name' => 'Donor User',
            'email' => 'donor@example.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $donor->id,
            'role' => 'donor',
        ]);

        // === 3. Requester ===
        $requester = User::create([
            'name' => 'Requester User',
            'email' => 'requester@example.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $requester->id,
            'role' => 'requester',
        ]);

        // === 4. Tambahan user dummy + role random ===
        User::factory(5)->create()->each(function ($user) {
            DB::table('user_roles')->insert([
                'user_id' => $user->id,
                'role' => collect(['donor', 'requester'])->random(),
            ]);
        });
    }
}
