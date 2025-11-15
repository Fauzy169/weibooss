<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUsersSeeder extends Seeder
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
                'password' => bcrypt('password'),
                'role' => 'administrator',
            ],
            [
                'name' => 'Customer Demo',
                'email' => 'customer@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ],
            [
                'name' => 'Sales Team',
                'email' => 'sales@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'sales',
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'keuangan',
            ],
            [
                'name' => 'Owner',
                'email' => 'owner@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'owner',
            ],
            [
                'name' => 'Gudang',
                'email' => 'gudang@weiboo.com',
                'password' => bcrypt('password'),
                'role' => 'gudang',
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Users dengan berbagai role berhasil dibuat!');
        $this->command->info('Login credentials:');
        $this->command->info('- admin@weiboo.com / password (Administrator)');
        $this->command->info('- customer@weiboo.com / password (Customer)');
        $this->command->info('- sales@weiboo.com / password (Sales)');
        $this->command->info('- kasir@weiboo.com / password (Kasir)');
        $this->command->info('- keuangan@weiboo.com / password (Keuangan)');
        $this->command->info('- owner@weiboo.com / password (Owner)');
        $this->command->info('- gudang@weiboo.com / password (Gudang)');
    }
}
