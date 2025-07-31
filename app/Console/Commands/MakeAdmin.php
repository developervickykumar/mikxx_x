<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Make a user an admin by their email address';

    public function handle()
    {
        $email = $this->argument('email');

        try {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("User with email {$email} not found");
                return 1;
            }
            
            if ($user->is_admin) {
                $this->info("User {$email} is already an admin");
                return 0;
            }
            
            $user->is_admin = true;
            $user->save();
            
            $this->info("User {$email} has been successfully made an admin!");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
} 