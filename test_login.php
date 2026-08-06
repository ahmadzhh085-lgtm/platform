<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;

// Check a few users
$users = User::limit(5)->get();
echo "=== Checking first 5 users ===\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Password is NULL: " . ($user->password === null ? 'YES' : 'NO') . "\n";
}

// Try login with a test user
echo "\n=== Testing Login ===\n";
$testEmail = 'ali.ibra33330@gmail.com';
$testPassword = 'password';

$user = User::where('email', $testEmail)->first();
if (!$user) {
    echo "User not found: $testEmail\n";
} else {
    echo "User found: {$user->email}\n";
    echo "Password in DB is NULL: " . ($user->password === null ? 'YES' : 'NO') . "\n";
    
    if ($user->password) {
        // Try to verify
        $verified = \Illuminate\Support\Facades\Hash::check($testPassword, $user->password);
        echo "Password verification result: " . ($verified ? 'MATCH' : 'NO MATCH') . "\n";
    } else {
        echo "Cannot verify - no password stored\n";
    }
}
