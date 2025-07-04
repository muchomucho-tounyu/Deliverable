<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Place::insert([
            [
                'name' => '栃木足利学校',
                'address' => '栃木県足利市昌平町2338',
                'latitude' => 36.3359860,
                'longitude' => 139.4535860,
            ],
            [
                'name' => '雪が谷大塚駅',
                'address' => '東京都大田区南雪谷2-2-16',
                'latitude' => 35.5920000,
                'longitude' => 139.6809720,
            ],
            [
                'name' => 'アルテリーベ横浜本店',
                'address' => '神奈川県横浜市中区日本大通り11 横浜情報文化センター1F',
                'latitude' => 35.4495970,
                'longitude' => 139.6380400,
            ],
            [
                'name' => '警視庁芝浦警察署',
                'address' => '東京都多摩市唐木田1丁目16‑2',
                'latitude'  => 35.6420800,
                'longitude' => 139.4193500,
            ],
            [
                'name' => '関東柔道整復専門学校',
                'address' => '東京都立川市曙町1-13-13',
                'latitude'  => 35.7078790,
                'longitude' => 139.4161140,
            ],
            [
                'name' => '岡山県真庭市鍋屋17-1',
                'address' => '岡山県真庭市鍋屋17-1',
                'latitude' => 35.0777170,
                'longitude' => 133.7518250,
            ],
            [
                'name' => '太尾見晴らしの丘公園',
                'address' => '神奈川県横浜市港北区大倉山6-40',
                'latitude' => 35.5324000,
                'longitude' => 139.6085000,
            ],
            [
                'name' => '彦根城',
                'address' => '滋賀県彦根市金亀町1-1',
                'latitude' => 35.2764771,
                'longitude' => 136.2518232,
            ],
            [
                'name' => '四ツ谷駅',
                'address' => '',
                'latitude' => 35.6862090,
                'longitude' => 139.7294260,
            ],
            [
                'name' => '明大前駅',
                'address' => '東京都世田谷区松原二丁目',
                'latitude' => 35.6684170,
                'longitude' => 139.6505000,
            ],
            [
                'name' => '三鷹市芸術文化センター 風のホール',
                'address' => '東京都三鷹市上連雀6-12-14',
                'latitude' => 35.6928179,
                'longitude' => 139.5582859,
            ],
            [
                'name' => '信濃町駅前',
                'address' => '東京都新宿区信濃町34',
                'latitude' => 35.6795160,
                'longitude' => 139.7197380,
            ],
            [
                'name' => '駒沢公園',
                'address' => '東京都世田谷区駒沢公園1-1',
                'latitude' => 35.6255289,
                'longitude' => 139.6617812,
            ],
            [
                'name' => '豊洲駅',
                'address' => '東京都江東区豊洲4-1-1',
                'latitude' => 35.653758,
                'longitude' => 139.795476,
            ],
            [
                'name' => '鹿嶋灘海浜公園',
                'address' => '茨城県鉾田市大竹390',
                'latitude' => 36.1505955,
                'longitude' => 140.5774134,
            ],
            [
                'name' => '象の鼻パーク',
                'address' => '神奈川県横浜市中区海岸通1',
                'latitude' => 35.449611,
                'longitude' => 139.643173,
            ],
            [
                'name' => 'ヘレナリゾートいわき ヘレナ国際ヴィラ',
                'address' => '福島県いわき市添野町頭巾平66-3',
                'latitude' => 36.946911,
                'longitude' => 140.815302,
            ],
            [
                'name' => '多摩川住宅給水塔',
                'address' => '東京都狛江市西和泉1-2',
                'latitude' => 35.637263,
                'longitude' => 139.563899,
            ],
            [
                'name' => '自由学園明日館',
                'address' => '東京都豊島区西池袋２丁目３１−３',
                'latitude' => 35.726703,
                'longitude' => 139.707228,
            ],


        ]);
        //
    }
}
