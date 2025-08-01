<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Song;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Song::insert([
            [
                'name' => '勿忘',
                'release_year' => 2021,
                'mv_url' => 'https://www.youtube.com/watch?v=zkZARKFuzNQ&list=RDzkZARKFuzNQ&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ソラニン',
                'release_year' => 2010,
                'mv_url' => 'https://www.youtube.com/watch?v=XNURRmk8YrQ&list=RDXNURRmk8YrQ&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '前前前世',
                'release_year' => 2016,
                'mv_url' => 'https://www.youtube.com/watch?v=PDSkFeMVNFs&list=RDPDSkFeMVNFs&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '虹',
                'release_year' => 2021,
                'mv_url' => 'https://www.youtube.com/watch?v=hkBbUf4oGfA&list=RDhkBbUf4oGfA&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'くせのうた',
                'release_year' => 2010,
                'mv_url' => 'https://www.youtube.com/watch?v=uYJS0O-9tIc&list=RDuYJS0O-9tIc&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mabataki',
                'release_year' => 2022,
                'mv_url' => 'https://www.youtube.com/watch?v=6h6AQbdTkaE&list=RD6h6AQbdTkaE&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '繋いだ手から',
                'release_year' => 2014,
                'mv_url' => 'https://www.youtube.com/watch?v=YKZ5KbClxp8&list=RDYKZ5KbClxp8&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '白日',
                'release_year' => 2019,
                'mv_url' => 'https://www.youtube.com/watch?v=ony539T074w&list=RDony539T074w&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '天体観測',
                'release_year' => 2001,
                'mv_url' => 'https://www.youtube.com/watch?v=j7CDb610Bg0&list=RDj7CDb610Bg0&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '明日への手紙',
                'release_year' => 2016,
                'mv_url' => 'https://www.youtube.com/watch?v=ytQ3Hs3WjQ4&list=RDytQ3Hs3WjQ4&start_radio=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]); //
    }
}
