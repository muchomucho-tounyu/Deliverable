@extends('layouts.app')

@section('header')
<h1>聖地一覧</h1>
@endsection

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<style>
    .post-list-wrapper {
        padding-top: 80px;
        /* ヘッダー高さ分の余白を追加 */
    }

    .post-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .post-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .post-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .post-title a {
        text-decoration: none;
        color: inherit;
    }

    .post-title a:hover {
        color: #667eea;
    }

    .post-image {
        max-width: 200px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .post-info {
        color: #666;
        margin-bottom: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .action-button {
        background: none;
        border: none;
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
    }

    .action-button:hover {
        background: rgba(102, 126, 234, 0.1);
        transform: scale(1.05);
    }

    .favorite-button {
        color: #666;
    }

    .favorite-button.favorited {
        color: #e53e3e;
    }

    .favorite-button.favorited:hover {
        background: rgba(229, 62, 62, 0.1);
    }

    .visit-button {
        color: #666;
    }

    .visit-button.visited {
        color: #38a169;
    }

    .visit-button.visited:hover {
        background: rgba(56, 161, 105, 0.1);
    }

    .heart-icon {
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .location-icon {
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .fixed-create-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .fixed-create-button:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }
</style>

<div class="post-list-wrapper">
    @foreach($posts as $post)
    <div class="post-item">
        <!-- 画像 -->
        @if(Str::startsWith($post->image, ['http://', 'https://']))
        <img src="{{ $post->image }}" alt="投稿画像" class="post-image">
        @elseif($post->image)
        <img src="{{ asset($post->image) }}" alt="投稿画像" class="post-image">
        @elseif($post->image_path)
        <img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" class="post-image">
        @endif

        {{-- タイトル --}}
        <h2 class="post-title"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>

        <!-- 場所名 -->
        <div class="post-info">
            <p><strong>📍 場所:</strong> {{ $post->place->name ?? '未設定' }}</p>

            <!-- 作品名または楽曲名-->
            @if ($post->work)
            <p><strong>🎬 作品:</strong> {{ $post->work->name }}</p>
            @endif

            @if ($post->song)
            <p><strong>🎵 楽曲:</strong> {{ $post->song->name }}</p>
            @endif
        </div>

        <!-- いいね・訪問済みボタン（横並び） -->
        <div class="action-buttons">
            <!-- いいねボタン -->
            <form action="{{ route('posts.favorite', $post) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="action-button favorite-button {{ auth()->check() && auth()->user()->hasFavorited($post) ? 'favorited' : '' }}">
                    <span class="heart-icon">
                        @if(auth()->check() && auth()->user()->hasFavorited($post))
                        ❤️
                        @else
                        🤍
                        @endif
                    </span>
                </button>
            </form>

            <!-- 訪問済みボタン -->
            <form action="{{ route('posts.visit', $post) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="action-button visit-button {{ auth()->check() && auth()->user()->hasVisited($post) ? 'visited' : '' }}">
                    <span class="location-icon">
                        @if(auth()->check() && auth()->user()->hasVisited($post))
                        🏁
                        @else
                        🚩
                        @endif
                    </span>
                </button>
            </form>
        </div>
    </div>
    @endforeach

    <a href="{{ route('posts.create') }}" class="fixed-create-button" title="投稿する">＋</a>

    <!-- ページネーション -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>

@endsection