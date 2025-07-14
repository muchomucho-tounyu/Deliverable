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
                'password' => Hash::make('password'),
                'image' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475262/animal_melt4_hamster_besv3f.png',
            ]
        );
    }
}
