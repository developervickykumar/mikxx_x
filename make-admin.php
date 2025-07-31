<?php

// Bootstrap Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

// Email to update
$email = 'ahlawat.riyansh@gmail.com';

try {
    // Find the user
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        echo "Error: User with email {$email} not found\n";
        exit(1);
    }
    
    // Check if already admin
    if ($user->is_admin) {
        echo "User {$email} is already an admin\n";
        exit(0);
    }
    
    // Make user admin
    $user->is_admin = true;
    $user->save();
    
    echo "User {$email} has been successfully made an admin!\n";
    exit(0);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 