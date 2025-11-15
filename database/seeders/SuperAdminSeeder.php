<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@weiboo.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'super_admin',
            'phone' => '081234567890',
            'address' => 'Weiboo Headquarters',
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: superadmin@weiboo.com');
        $this->command->info('Password: superadmin123');
    }
}
