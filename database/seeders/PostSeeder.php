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

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752476680/1621539_s_r2dcpx.jpg',
            'place_detail' => '成城学園',
            'title' => '花より男子の学校',
            'body' => '学校生活だけでなく、学園祭のシーンでも使われている。',
            'latitude' => 35.645364,
            'longitude' => 139.600542,
        ]);

        $post1->people()->attach([4, 14]);


        $post2 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id' => 2,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475417/yudai927_dsw002_TP_V.jpg_kdhbiq.webp',
            'place_detail' => '雪が谷大塚駅',
            'title' => '主人公たちが再会する駅',
            'body' => '音と練がそれぞれ利用するコインランドリーは、音が「雪が谷大塚南口店」、練が「雪が谷大塚北口店」を訪れている。ただ二人がコインランドリーを利用するだけの場面だが、二人のすれ違いを感じさせる印象的なシーンになっている。',
            'latitude' => 35.5920000,
            'longitude' => 139.6809720,
        ]);

        $post2->people()->attach([2, 8]);

        $post3 = Post::create([
            'user_id' => 1,
            'work_id' => 3,
            'song_id' => null,
            'place_id' => 3,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475544/PAK65_torinosubottlenarabu20130825_TP_V4.jpg_uhsrye.webp',
            'place_detail' => 'アルテリーベ横浜本店',
            'title' => 'プロポーズシーン',
            'body' => 'デートや話し合いのシーンでも。',
            'latitude' => 35.4495970,
            'longitude' => 139.6380400,
        ]);

        $post3->people()->attach([1, 12]);

        $post4 = Post::create([
            'user_id' => 1,
            'work_id' => 4,
            'song_id' => null,
            'place_id' => 4,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475688/susipaku1128PAR53416346_TP_V4.jpg_fjyuto.webp',
            'place_detail' => ' 警視庁芝浦警察署',
            'title' => '捜査本部として使用された建物',
            'body' => '捜査や交番のシーン。特に主人公たちが事件の打ち合わせや日常の様子を見せるシーンで登場。',
            'latitude'  => 35.6420800,
            'longitude' => 139.4193500,
        ]);

        $post4->people()->attach([3, 12]);

        $post5 = Post::create([
            'user_id' => 1,
            'work_id' => 5,
            'song_id' => null,
            'place_id' => 5,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752498801/27300943_s_sudfwy.jpg',
            'place_detail' => '関東柔道整復専門学校',
            'title' => '手話教室「手話ふぁみりー」の外観',
            'body' => '学校生活の描写や友達との交流、授業のシーンで映り、リアルな学生生活の舞台に。',
            'latitude'  => 35.7078790,
            'longitude' => 139.4161140,
        ]);

        $post5->people()->attach([7, 16]);

        $post6 = Post::create([
            'user_id' => 1,
            'work_id' => 6,
            'song_id' => null,
            'place_id' => 6,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475555/PK-sc01-PAR55010-b_TP_V.jpg_jvgjzh.webp',
            'place_detail' => '旧遷喬尋常小学校',
            'title' => '鈴木一平が通う学校',
            'body' => '昭和の雰囲気を残す建物として、小学校のシーンや町の背景に使われて、懐かしい時代感を演出していた。',
            'latitude' => 35.0777170,
            'longitude' => 133.7518250,
        ]);

        $post6->people()->attach([11, 13, 17]);

        $post7 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id' => 7,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475242/shiokazeIMG_6990_TP_V.jpg_b3cejl.webp',
            'place_detail' => '太尾見晴らしの丘公園',
            'title' => '主人公たちが訪れる公園のシーン',
            'body' => '広々とした公園での散歩や会話の場面、未来への不安や希望を語り合う大切な場所として登場。',
            'latitude' => 35.5324000,
            'longitude' => 139.6085000,

        ]);

        $post7->people()->attach([8, 15]);

        $post8 = Post::create([
            'user_id' => 1,
            'work_id' => 8,
            'song_id' => null,
            'place_id' => 8,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475700/YAT4M3A7354_TP_V4.jpg_dgq89b.webp',
            'place_detail' => '彦根城',
            'title' => '戦闘シーン',
            'body' => '江戸時代の風情を残す城として、幕末の京都や各地の歴史的な舞台の代わりに登場。',
            'latitude' => 35.2755510,
            'longitude' => 136.2542770,
        ]);

        $post8->people()->attach([9]);

        $post9 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id' => 9,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499349/paku729-12780_TP_V.jpg_m5xqjo.webp',
            'place_detail' => '四ツ谷駅',
            'title' => '主人公がすれ違う場面',
            'body' => '主人公の一人が四ツ谷駅近辺の学校に通っている設定。電車に乗るシーンなどで四ツ谷駅の特徴が出ている。',
            'latitude' => 35.6862090,
            'longitude' => 139.7294260,
        ]);

        $post9->people()->attach([5, 6]);

        $post10 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id' => 10,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499335/fk-PAUI0276_TP_V.jpg_jzlubp.webp',
            'place_detail' => '明大前駅',
            'title' => '主人公が出会うシーン',
            'body' => '待ち合わせしたり、歩いたりするシーンが多く、二人の青春の日常を象徴する場所に。',
            'latitude' => 35.6684170,
            'longitude' => 139.6505000,
        ]);

        $post10->people()->attach([2, 10]);

        $post11 = Post::create([
            'user_id' => 1,
            'work_id' => 10,
            'song_id' => 1,
            'place_id' => 11,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499743/TKL-sc-_R6_9455-j_TP_V.jpg_yt0ssx.webp',
            'place_detail' => '三鷹市芸術文化センター 風のホール',
            'title' => 'バンドが演奏しているホール',
            'body' => 'ライブシーンや、メンバーが室内で過ごしている落ち着いたシーンに。',
            'latitude' => 35.6928179,
            'longitude' => 139.5582859,
        ]);

        $post11->people()->attach([20]);

        $post12 = Post::create([
            'user_id' => 1,
            'work_id' => 7,
            'song_id' => 2,
            'place_id' => 7,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475242/shiokazeIMG_6990_TP_V.jpg_b3cejl.webp',
            'place_detail' => '太尾見晴らしの丘公園',
            'title' => '考え事をしている公園',
            'body' => '広がる景色や空が印象的',
            'latitude' => 35.5324000,
            'longitude' => 139.6085000,
        ]);

        $post12->people()->attach([19]);

        $post13 = Post::create([
            'user_id' => 1,
            'work_id' => 9,
            'song_id' => 3,
            'place_id' => 12,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475939/mitakaIMG_8866_TP_V4.jpg_rz6ota.webp',
            'place_detail' => '信濃町駅前歩道橋',
            'title' => '走ったり駆け抜けるシーン',
            'body' => '歩道橋の上を駆け抜ける、疾走感あふれる場面に登場。',
            'latitude' => 35.6795160,
            'longitude' => 139.7197380,
        ]);

        $post13->people()->attach([24]);

        $post14 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 4,
            'place_id' => 13,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499507/makinamiA7206415-edit_TP_V4_nu6ehf.jpg',
            'place_detail' => '駒沢公園',
            'title' => '歌唱シーン',
            'body' => '公園の緑と開放感が曲とマッチしてる。',
            'latitude' => 35.6255289,
            'longitude' => 139.6617812,
        ]);

        $post14->people()->attach([10]);

        $post15 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 5,
            'place_id' => 14,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499322/toyosuPAKU8695_TP_V.jpg_w7ezcx.webp',
            'place_detail' => '豊洲駅',
            'title' => '待ち合わせのシーン',
            'body' => '日常感と都会の空気感が感じられる場所になっている。',
            'latitude' => 35.653758,
            'longitude' => 139.795476,
        ]);

        $post15->people()->attach([12]);

        $post16 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 6,
            'place_id' => 15,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752475950/fjk_grandgreenIMG_7614_TP_V4.jpg_niyms0.webp',
            'place_detail' => '鹿嶋灘海浜公園',
            'title' => '菅田将暉が歩くシーン',
            'body' => 'ひたすら菅田将暉が歩き人とすれ違う。波の音や海風が伝わる。',
            'latitude' => 36.1505955,
            'longitude' => 140.5774134,
        ]);

        $post16->people()->attach([10, 25]);

        $post17 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 7,
            'place_id' => 16,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499495/yukilo_25108010_TP_V_fo97id.jpg',
            'place_detail' => '象の鼻パーク',
            'title' => '手を繋いでいるシーン。',
            'body' => '曲名に関連していろんな人が手を繋いでいるところ。',
            'latitude' => 35.449611,
            'longitude' => 139.643173,
        ]);

        $post17->people()->attach([21]);

        $post18 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 8,
            'place_id' => 17,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499730/bobuatamiP50401061812_TP_V.jpg_gpzuai.webp',
            'place_detail' => 'ヘレナリゾートいわき ヘレナ国際ヴィラ',
            'title' => '豪華な部屋やテラス',
            'body' => '歌詞の孤独感が表れてる。',
            'latitude' => 36.946911,
            'longitude' => 140.815302,
        ]);

        $post18->people()->attach([23]);

        $post19 = Post::create([
            'user_id' => 1,
            'work_id' => null,
            'song_id' => 9,
            'place_id' => 18,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499578/236RED20404A_TP_V4.jpg_vp0tgf.webp',
            'place_detail' => '多摩川住宅給水塔',
            'title' => '高い場所から街を見渡すシーン',
            'body' => '夜空を見上げるイメージで、夢や希望を感じさせるシンボリックな背景。',
            'latitude' => 35.637263,
            'longitude' => 139.563899,
        ]);

        $post19->people()->attach([22]);

        $post20 = Post::create([
            'user_id' => 1,
            'work_id' => 2,
            'song_id' => 10,
            'place_id' => 19,

            'image_path' => 'https://res.cloudinary.com/ddmyych6n/image/upload/v1752499761/R2-010A1825-j_TP_V.jpg_tnadav.webp',
            'place_detail' => '自由学園明日館',
            'title' => '想いの居場所',
            'body' => 'MVのさまざまなところに起用。夕暮れや朝焼けの光が差し込んでとてもノスタルジックな歴史ある建物。',
            'latitude' => 35.726703,
            'longitude' => 139.707228,
        ]);

        $post20->people()->attach([2, 18]);
        //
    }
}
