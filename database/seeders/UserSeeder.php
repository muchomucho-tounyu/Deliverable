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
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'testuser',
                'password' => bcrypt('password'),
                'image' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475262/animal_melt4_hamster_besv3f.png',
            ]
        );
        User::firstOrCreate(
            ['email' => 'testuser2@example.com'],
            [
                'name' => 'testuser2',
                'password' => bcrypt('password'),
                'image' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475262/animal_melt4_hamster_besv3f.png',
            ]
        );
    }
}
