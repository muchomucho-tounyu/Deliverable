<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post1 = Post::create([
            'user_id' => 1,
            'work_id' => 1,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
        ]);

        $post1->people()->attach([4, 13]);

        $post2 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '雪が谷大塚駅',
            'image' => '',
        ]);

        $post2->people()->attach([2, 8]);

        $post3 = Post::create([
            'user_id' => 1,
            'work_id' => 3,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '横浜みなとみらい',
            'image' => '',
        ]);

        $post3->people()->attach([1, 12]);

        $post4 = Post::create([
            'user_id' => 1,
            'work_id' => 4,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '多摩川河川敷',
            'image' => '',
        ]);

        $post4->people()->attach([3, 12]);

        $post5 = Post::create([
            'user_id' => 1,
            'work_id' => 5,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '立川駅',
            'image' => '',
        ]);

        $post5->people()->attach([7, 16]);

        $post6 = Post::create([
            'user_id' => 1,
            'work_id' => 6,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '台東区谷中',
            'image' => '',
        ]);

        $post6->people()->attach([11, 13, 17]);

        $post7 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '多摩川河川敷',
            'image' => '',
        ]);

        $post7->people()->attach([8, 15]);

        $post8 = Post::create([
            'user_id' => 1,
            'work_id' => 8,
            'song_id' => null,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '彦根城',
            'image' => '',
        ]);

        $post8->people()->attach([9]);

        $post9 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '四ツ谷駅',
            'image' => '',
        ]);

        $post9->people()->attach([5, 6]);

        $post10 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '明大前',
            'image' => '',
        ]);

        $post10->people()->attach([2, 10]);

        $post11 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '三鷹市芸術文化センター 風のホール',
            'image' => '',
        ]);

        $post11->people()->attach([20]);

        $post12 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => 'リバーサイド商店街',
            'image' => '',
        ]);

        $post12->people()->attach([19]);

        $post13 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '信濃町駅前歩道橋',
            'image' => '',
        ]);

        $post13->people()->attach([23]);

        $post14 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 4,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '駒沢公園',
            'image' => '',
        ]);

        $post14->people()->attach([10]);

        $post15 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 5,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '豊洲駅',
            'image' => '',
        ]);

        $post15->people()->attach([12]);

        $post16 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 6,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '鹿嶋灘海浜公園',
            'image' => '',
        ]);

        $post16->people()->attach([10, 24]);

        $post17 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 7,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '象の鼻パーク',
            'image' => '',
        ]);

        $post17->people()->attach([20]);

        $post18 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 8,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => 'ヘレナ国際ホテル',
            'image' => '',
        ]);

        $post18->people()->attach([22]);

        $post19 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 9,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '多摩川住宅給水塔',
            'image' => '',
        ]);

        $post19->people()->attach([21]);

        $post20 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id'=>,

            'image_path'=>'',
            'place_detail'=>'',
            'title'=>'栃木足利学校',
            'body'=>'',
            'latitude'=>,
            'longitude'=>,
            'location' => '大田区東雪谷',
            'image' => '',
        ]);

        $post20->people()->attach([2, 17]); //
    }
}
