<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Create the Admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Create the user
        $user = User::firstOrCreate(
            ['email' => 'wend@gmail.com'],
            [
                'name' => 'Wend Admin',
                'password' => Hash::make('wend1234'),
            ]
        );

        // Assign the Admin role
        if (!$user->hasRole('Admin')) {
            $user->assignRole($adminRole);
        }
    }
}


