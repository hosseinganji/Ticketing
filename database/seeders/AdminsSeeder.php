<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1
        User::updateOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin1',
                'password' => Hash::make('123456'),
                'is_admin_level' => 1,
            ]
        );

        // 2
        User::updateOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Admin2',
                'password' => Hash::make('123456'),
                'is_admin_level' => 2,
            ]
        );
    }
}
