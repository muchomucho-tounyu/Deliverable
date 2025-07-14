<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Place;
use App\Models\Person;
use App\Models\Work;
use App\Models\Song;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'places', 'people', 'works', 'songs'])->whereNotNull('latitude')->whereNotNull('longitude');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%")
                    ->orWhereHas('places', function ($placeQuery) use ($keyword) {
                        $placeQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('people', function ($personQuery) use ($keyword) {
                        $personQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('works', function ($workQuery) use ($keyword) {
                        $workQuery->where('title', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('songs', function ($songQuery) use ($keyword) {
                        $songQuery->where('title', 'like', "%{$keyword}%");
                    });
            });
        }

        // 位置情報での検索（緯度経度の範囲指定）
        if ($request->filled(['lat', 'lng', 'radius'])) {
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = $request->radius; // km単位

            // 緯度経度の範囲を計算（簡易的な計算）
            $latRange = $radius / 111.0; // 1度 ≈ 111km
            $lngRange = $radius / (111.0 * cos(deg2rad($lat)));

            $query->whereBetween('latitude', [$lat - $latRange, $lat + $latRange])
                ->whereBetween('longitude', [$lng - $lngRange, $lng + $lngRange]);
        }

        // カテゴリ検索
        if ($request->filled('category')) {
            $category = $request->category;
            switch ($category) {
                case 'places':
                    $query->whereHas('places');
                    break;
                case 'people':
                    $query->whereHas('people');
                    break;
                case 'works':
                    $query->whereHas('works');
                    break;
                case 'songs':
                    $query->whereHas('songs');
                    break;
            }
        }

        $posts = $query->get();
        $googleMapsApiKey = config('services.google_maps.api_key');

        // 検索結果の統計
        $stats = [
            'total' => $posts->count(),
            'places' => 0,
            'people' => 0,
            'works' => 0,
            'songs' => 0,
        ];

        // 各カテゴリの統計を計算
        foreach ($posts as $post) {
            if ($post->places && $post->places->count() > 0) $stats['places']++;
            if ($post->people && $post->people->count() > 0) $stats['people']++;
            if ($post->works && $post->works->count() > 0) $stats['works']++;
            if ($post->songs && $post->songs->count() > 0) $stats['songs']++;
        }

        return view('map', compact('posts', 'googleMapsApiKey', 'stats'));
    }

    // AJAX用の検索API
    public function search(Request $request)
    {
        $query = Post::with(['user', 'places', 'people', 'works', 'songs']);

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%")
                    ->orWhereHas('places', function ($placeQuery) use ($keyword) {
                        $placeQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('people', function ($personQuery) use ($keyword) {
                        $personQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('works', function ($workQuery) use ($keyword) {
                        $workQuery->where('title', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('songs', function ($songQuery) use ($keyword) {
                        $songQuery->where('title', 'like', "%{$keyword}%");
                    });
            });
        }

        $posts = $query->get();

        return response()->json([
            'posts' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'latitude' => $post->latitude,
                    'longitude' => $post->longitude,
                    'user' => $post->user->name,
                    'places' => $post->places->pluck('name'),
                    'people' => $post->people->pluck('name'),
                    'works' => $post->works->pluck('title'),
                    'songs' => $post->songs->pluck('title'),
                    'url' => route('posts.show', $post->id)
                ];
            })
        ]);
    }
}
