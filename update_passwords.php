<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$users = [
    'customer@weiboo.com' => 'customer123',
    'admin@weiboo.com' => 'admin123',
    'sales@weiboo.com' => 'sales123',
    'kasir@weiboo.com' => 'kasir123',
    'keuangan@weiboo.com' => 'keuangan123',
    'owner@weiboo.com' => 'owner123',
    'gudang@weiboo.com' => 'gudang123',
];

foreach ($users as $email => $password) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->password = Hash::make($password);
        $user->save();
        echo "Updated password for: $email\n";
    }
}

echo "All passwords updated successfully!\n";
