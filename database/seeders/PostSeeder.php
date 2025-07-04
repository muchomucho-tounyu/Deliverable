<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Person;
use App\Models\Work;
use App\Models\Song;
use App\Models\Place;

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
            'place_id' => 1,

            'image_path' => '',
            'place_detail' => '成城学園',
            'title' => '花より男子の学校',
            'body' => null,
            'latitude' => 35.645364,
            'longitude' => 139.600542,
        ]);

        $post1->people()->attach([4, 13]);
        $post1->places()->attach([1]);

        $post2 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id' => 2,

            'image_path' => '',
            'place_detail' => '雪が谷大塚駅',
            'title' => 'いつかこの恋を思い出してしまうの駅',
            'body' => null,
            'latitude' => 35.5920000,
            'longitude' => 139.6809720,
        ]);

        $post2->people()->attach([2, 8]);
        $post2->places()->attach([2]);

        $post3 = Post::create([
            'user_id' => 1,
            'work_id' => 3,
            'song_id' => null,
            'place_id' => 3,

            'image_path' => '',
            'place_detail' => 'アルテリーベ横浜本店',
            'title' => '逃げ恥プロポーズシーン',
            'body' => null,
            'latitude' => 35.4495970,
            'longitude' => 139.6380400,
        ]);

        $post3->people()->attach([1, 12]);
        $post3->places()->attach([3]);

        $post4 = Post::create([
            'user_id' => 1,
            'work_id' => 4,
            'song_id' => null,
            'place_id' => 4,

            'image_path' => '',
            'place_detail' => ' 警視庁芝浦警察署',
            'title' => 'MIU404捜査本部として使用された建物',
            'body' => null,
            'latitude'  => 35.6420800,
            'longitude' => 139.4193500,
        ]);

        $post4->people()->attach([3, 12]);
        $post4->places()->attach([4]);

        $post5 = Post::create([
            'user_id' => 1,
            'work_id' => 5,
            'song_id' => null,
            'place_id' => 5,

            'image_path' => '',
            'place_detail' => '関東柔道整復専門学校',
            'title' => '手話教室「手話ふぁみりー」の外観',
            'body' => null,
            'latitude'  => 35.7078790,
            'longitude' => 139.4161140,
        ]);

        $post5->people()->attach([7, 16]);
        $post5->places()->attach([5]);

        $post6 = Post::create([
            'user_id' => 1,
            'work_id' => 6,
            'song_id' => null,
            'place_id' => 6,

            'image_path' => '',
            'place_detail' => '旧遷喬尋常小学校',
            'title' => '鈴木一平が通う学校',
            'body' => null,
            'latitude' => 35.0777170,
            'longitude' => 133.7518250,
        ]);

        $post6->people()->attach([11, 13, 17]);
        $post6->places()->attach([6]);

        $post7 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id' => 7,

            'image_path' => '',
            'place_detail' => '太尾見晴らしの丘公園',
            'title' => '主人公たちが訪れる公園のシーン',
            'body' => null,
            'latitude' => 35.5324000,
            'longitude' => 139.6085000,

        ]);

        $post7->people()->attach([8, 15]);
        $post7->places()->attach([7]);

        $post8 = Post::create([
            'user_id' => 1,
            'work_id' => 8,
            'song_id' => null,
            'place_id' => 8,

            'image_path' => '',
            'place_detail' => '彦根城',
            'title' => '',
            'body' => '',
            'latitude' => 35.2755510,
            'longitude' => 136.2542770,
        ]);

        $post8->people()->attach([9]);
        $post8->places()->attach([8]);

        $post9 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id' => 9,

            'image_path' => '',
            'place_detail' => '四ツ谷駅',
            'title' => '主人公がすれ違う場面',
            'body' => '',
            'latitude' => 35.6862090,
            'longitude' => 139.7294260,
        ]);

        $post9->people()->attach([5, 6]);
        $post9->places()->attach([9]);

        $post10 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id' => 10,

            'image_path' => '',
            'place_detail' => '明大前駅',
            'title' => '主人公が出会うシーン',
            'body' => '',
            'latitude' => 35.6684170,
            'longitude' => 139.6505000,
        ]);

        $post10->people()->attach([2, 10]);
        $post10->places()->attach([10]);

        $post11 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id' => 11,

            'image_path' => '',
            'place_detail' => '三鷹市芸術文化センター 風のホール',
            'title' => '',
            'body' => '',
            'latitude' => 35.6928179,
            'longitude' => 139.5582859,
        ]);

        $post11->people()->attach([20]);
        $post11->places()->attach([11]);

        $post12 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id' => 7,

            'image_path' => '',
            'place_detail' => '太尾見晴らしの丘公園',
            'title' => '',
            'body' => '',
            'latitude' => 35.5324000,
            'longitude' => 139.6085000,
        ]);

        $post12->people()->attach([19]);
        $post12->places()->attach([7]);

        $post13 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id' => 12,

            'image_path' => '',
            'place_detail' => '信濃町駅前歩道橋',
            'title' => '',
            'body' => '',
            'latitude' => 35.6795160,
            'longitude' => 139.7197380,
        ]);

        $post13->people()->attach([23]);
        $post13->places()->attach([12]);

        $post14 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 4,
            'place_id' => 13,

            'image_path' => '',
            'place_detail' => '駒沢公園',
            'title' => '',
            'body' => '',
            'latitude' => 35.6255289,
            'longitude' => 139.6617812,
        ]);

        $post14->people()->attach([10]);
        $post14->places()->attach([13]);

        $post15 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 5,
            'place_id' => 14,

            'image_path' => '',
            'place_detail' => '豊洲駅',
            'title' => '',
            'body' => '',
            'latitude' => 35.653758,
            'longitude' => 139.795476,
        ]);

        $post15->people()->attach([12]);
        $post15->places()->attach([14]);

        $post16 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 6,
            'place_id' => 15,

            'image_path' => '',
            'place_detail' => '鹿嶋灘海浜公園',
            'title' => '',
            'body' => '',
            'latitude' => 36.1505955,
            'longitude' => 140.5774134,
        ]);

        $post16->people()->attach([10, 24]);
        $post16->places()->attach([15]);

        $post17 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 7,
            'place_id' => 16,

            'image_path' => '',
            'place_detail' => '象の鼻パーク',
            'title' => '',
            'body' => '',
            'latitude' => 35.449611,
            'longitude' => 139.643173,
        ]);

        $post17->people()->attach([20]);
        $post17->places()->attach([16]);

        $post18 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 8,
            'place_id' => 17,

            'image_path' => '',
            'place_detail' => 'ヘレナリゾートいわき ヘレナ国際ヴィラ',
            'title' => '',
            'body' => '',
            'latitude' => 36.946911,
            'longitude' => 140.815302,
        ]);

        $post18->people()->attach([22]);
        $post18->places()->attach([17]);

        $post19 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 9,
            'place_id' => 18,

            'image_path' => '',
            'place_detail' => '多摩川住宅給水塔',
            'title' => '',
            'body' => '',
            'latitude' => 35.637263,
            'longitude' => 139.563899,
        ]);

        $post19->people()->attach([21]);
        $post19->places()->attach([18]);

        $post20 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id' => 19,

            'image_path' => '',
            'place_detail' => '自由学園明日館',
            'title' => '',
            'body' => '',
            'latitude' => 35.726703,
            'longitude' => 139.707228,
        ]);

        $post20->people()->attach([2, 17]);
        $post20->places()->attach([19]);
        //
    }
}
