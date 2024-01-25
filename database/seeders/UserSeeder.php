<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin')->exists()) {
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'agency' => '0',
                'branch' => '0',
                'phone' => 'xxxxxxxx',
                'dpm' => '0',
            ]);

            $user->assignRole('admin');
        } else {
            $user = User::where('email', 'admin')->first();
            $user->assignRole('admin');
        }

    }
}
