@extends('layouts.app')

@section('header')
<h1>聖地詳細</h1>
@endsection

@section('content')
<div class="pt-32">

    <h2>{{ $post->title }}</h2>

    @if ($post->image)
    @if(Str::startsWith($post->image, 'http'))
    <div style="margin-bottom: 1em;">
        <img src="{{ $post->image }}" alt="投稿画像" style="max-width: 100%; height: auto;">
    </div>
    @else
    <div style="margin-bottom: 1em;">
        <img src="{{ asset('storage/' . ltrim($post->image, '/')) }}" alt="投稿画像" style="max-width: 100%; height: auto;">
    </div>
    @endif
    @endif

    @if ($post->work)
    <p><strong>作品名：</strong>{{ $post->work->name }}</p>
    @endif

    @if ($post->song)
    <p><strong>楽曲名：</strong>{{ $post->song->name }}</p>
    @endif

    @if ($post->people && $post->people->isNotEmpty())
    <p><strong>出演者・アーティスト名：</strong>
        {{ $post->people->pluck('name')->join(', ') }}
    </p>
    @else
    <p><strong>出演者・アーティスト名：</strong> 未設定</p>
    @endif

    <p><strong>場所名：</strong> {{ optional($post->place)->name ?? '未設定' }}</p>
    <p><strong>住所：</strong> {{ optional($post->place)->address ?? '不明' }}</p>



    <p><strong>ロケシーン：</strong> {{ $post->place_detail ?? 'なし' }}</p>
    <p><strong>コメント：</strong><br>{!! nl2br(e($post->body)) ?? 'コメントなし' !!}</p>

    <p><strong>投稿者：</strong> {{ $post->user->name ?? '不明' }}</p>
    <p><strong>投稿日：</strong> {{ $post->created_at->format('Y/m/d H:i') }}</p>

    <!-- いいねボタン -->
    <form action="{{ route('posts.favorite', $post) }}" method="POST">
        @csrf
        <button type="submit">
            @if(auth()->check() && auth()->user()->hasFavorited($post))
            ❤️ いいね済み
            @else
            🤍 いいね
            @endif
        </button>
    </form>

    <!-- 訪問済みボタン -->
    <form action="{{ route('posts.visit', $post) }}" method="POST">
        @csrf
        <button type="submit">
            @if(auth()->check() && auth()->user()->hasVisited($post))
            👣 訪問済み
            @else
            ☁️ 未開拓
            @endif
        </button>
    </form>

    <style>
        .comment-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 32px 24px;
            margin-top: 40px;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .comment-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 20px;
        }

        .comment-list {
            margin-bottom: 30px;
        }

        .comment-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.07);
        }

        .comment-user {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .comment-body {
            color: #333;
            margin-bottom: 6px;
            white-space: pre-line;
        }

        .comment-date {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .comment-form {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.07);
        }

        .comment-form textarea {
            width: 100%;
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            padding: 10px 14px;
            font-size: 1rem;
            margin-bottom: 12px;
            background: #fff;
            transition: border-color 0.2s;
        }

        .comment-form textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .comment-form button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .comment-form button:hover {
            background: #667eea;
            transform: translateY(-2px);
        }
    </style>

    <div class="comment-section">
        <div class="comment-title">コメント一覧</div>
        <div class="comment-list">
            @forelse($post->comments as $comment)
            <div class="comment-card">
                <div class="comment-user">{{ $comment->user->name }}</div>
                <div class="comment-body">{{ $comment->body }}</div>
                <div class="comment-date">{{ $comment->created_at->format('Y/m/d H:i') }}</div>
            </div>
            @empty
            <div style="color:#888;">まだコメントはありません。</div>
            @endforelse
        </div>
        <form action="{{ route('comments.store',$post) }}" method="POST" class="comment-form">
            @csrf
            <textarea name="body" placeholder="コメントを書く" rows="3" required></textarea>
            <button type="submit">送信</button>
        </form>
    </div>


    <div class="edit"><a href="/posts/{{ $post->id }}/edit">編集</a></div>


    <p><a href="{{ route('posts.index') }}">一覧へ戻る</a></p>

</div>
@endsection