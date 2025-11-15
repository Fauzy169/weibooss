<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@weiboo.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrator',
            ],
            [
                'name' => 'Customer Demo',
                'email' => 'customer@weiboo.com',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Sales Team',
                'email' => 'sales@weiboo.com',
                'password' => Hash::make('sales123'),
                'role' => 'sales',
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@weiboo.com',
                'password' => Hash::make('kasir123'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@weiboo.com',
                'password' => Hash::make('keuangan123'),
                'role' => 'keuangan',
            ],
            [
                'name' => 'Owner',
                'email' => 'owner@weiboo.com',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ],
            [
                'name' => 'Gudang',
                'email' => 'gudang@weiboo.com',
                'password' => Hash::make('gudang123'),
                'role' => 'gudang',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
