<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::insert([
            [
                'name' => '新垣結衣',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '有村架純',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '綾野剛',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '井上真央',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '神木隆之介',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '上白石萌音',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '川口春奈',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '高良健吾',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '佐藤健',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '菅田将暉',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '堤真一',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '星野源',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '堀北真希',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '松本潤',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '宮﨑あおい',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '目黒蓮',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '吉岡秀隆',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '手嶌葵',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ASIAN KUNG-FU GENERATION',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Awesome City Club',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'back number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'BUMP OF CHICKEN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'King Gnu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'RADWIMPS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vaundy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]); //
    }
}
