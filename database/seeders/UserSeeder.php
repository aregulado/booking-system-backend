<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'API User',
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        $this->command->info('API User created with token: ' . $token);
    }
}
