<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Work;
use App\Models\Song;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '新垣結衣',
                'work_ids' => [3],
            ],
            [
                'name' => '有村架純',
                'work_ids' => [1, 10],
                'song_ids' => [10],
            ],
            [
                'name' => '綾野剛',
                'work_ids' => [4],
            ],
            [
                'name' => '井上真央',
                'work_ids' => [1],
            ],
            [
                'name' => '神木隆之介',
                'work_ids' => [9],
            ],
            [
                'name' => '上白石萌音',
                'work_ids' => [9],
            ],
            [
                'name' => '川口春奈',
                'work_ids' => [5],
            ],
            [
                'name' => '高良健吾',
                'work_ids' => [2, 7],
            ],
            [
                'name' => '佐藤健',
                'work_ids' => [8],
            ],
            [
                'name' => '菅田将暉',
                'work_ids' => [10],
                'song_ids' => [4, 6],
            ],
            [
                'name' => '堤真一',
                'work_ids' => [6],
            ],
            [
                'name' => '星野源',
                'work_ids' => [4],
                'song_ids' => [5],
            ],
            [
                'name' => '堀北真希',
                'work_ids' => [6],
            ],
            [
                'name' => '松本潤',
                'work_ids' => [1],
            ],
            [
                'name' => '宮﨑あおい',
                'work_ids' => [7],
            ],
            [
                'name' => '目黒蓮',
                'work_ids' => [5],
            ],
            [
                'name' => '吉岡秀隆',
                'work_ids' => [6],
            ],
            [
                'name' => '手嶌葵',
                'work_ids' => [2],
                'song_ids' => [10],
            ],
            [
                'name' => 'ASIAN KUNG-FU GENERATION',
                'work_ids' => [7],
                'song_ids' => [2],
            ],
            [
                'name' => 'Awesome City Club',
                'work_ids' => [10],
                'song_ids' => [1],
            ],
            [
                'name' => 'back number',
                'song_ids' => [7],
            ],
            [
                'name' => 'BUMP OF CHICKEN',
                'song_ids' => [9],
            ],
            [
                'name' => 'King Gnu',
                'song_ids' => [8],
            ],
            [
                'name' => 'RADWIMPS',
                'work_ids' => [9],
                'song_ids' => [3],
            ],
            [
                'name' => 'Vaundy',
                'song_ids' => [6],
            ],
        ];
        foreach ($data as $entry) {
            $person = Person::where('name', $entry['name'])->first();

            if (!$person) continue;

            // Person ⇄ Work（出演）
            if (!empty($entry['work_ids'])) {
                $person->works()->attach($entry['work_ids']);
            }

            // Person ⇄ Song（歌唱）
            if (!empty($entry['song_ids'])) {
                $person->songs()->attach($entry['song_ids']);
            }
            if (!empty($entry['work_ids']) && !empty($entry['song_ids'])) {
                foreach ($entry['work_ids'] as $workId) {
                    $work = Work::find($workId);
                    if ($work) {
                        $work->songs()->attach($entry['song_ids']);
                    }
                }
            }
        } //
    }
}
