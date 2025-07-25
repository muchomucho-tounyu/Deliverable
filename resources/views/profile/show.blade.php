<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>プロフィールページ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @extends('layouts.app')

    @section('header')
    <h1>プロフィール</h1>
    @endsection

    @section('content')
    <div class="profile-wrapper" style="max-width:700px;margin:0 auto; padding-top:64px;">
        <div class="profile-card" style="background:#fff;border-radius:18px;box-shadow:0 4px 16px rgba(102,126,234,0.10);padding:36px 28px 32px 28px;">
            <div style="display:flex;align-items:center;gap:18px;">
                <img src="{{ $user->image ? asset('storage/' . ltrim($user->image, '/')) : asset('images/default-user.png') }}" alt="ユーザー画像" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(102,126,234,0.10);background:#f3f4f6;">
                <div>
                    <div style="font-size:1.5rem;font-weight:bold;color:#333;">{{ $user->name }}</div>
                    @if($user->bio)
                    <div style="color:#888;font-size:1.02rem;margin-top:4px;">{{ $user->bio }}</div>
                    @endif
                </div>
                @auth
                @if(auth()->id() !== $user->id)
                <form action="{{ auth()->user()->isFollowing($user->id) ? route('profile.unfollow', $user->id) : route('profile.follow', $user->id) }}" method="POST" style="margin-left:auto;">
                    @csrf
                    <button type="submit"
                        class="follow-btn {{ auth()->user()->isFollowing($user->id) ? 'following' : '' }}">
                        {{ auth()->user()->isFollowing($user->id) ? 'フォロー中（解除）' : 'フォロー' }}
                    </button>
                </form>
                @endif
                @endauth
            </div>
            <div class="profile-follows" style="display:flex;gap:24px;font-size:1.08rem;margin:18px 0 0 0;justify-content:left;">
                <a href="{{ route('profile.followings', $user->id) }}" style="color:#667eea;font-weight:bold;background:#f3f4f6;padding:4px 14px;border-radius:8px;text-decoration:none;">フォロー <span class="profile-follow-count">{{ $user->followings->count() }}</span></a>
                <a href="{{ route('profile.followers', $user->id) }}" style="color:#667eea;font-weight:bold;background:#f3f4f6;padding:4px 14px;border-radius:8px;text-decoration:none;">フォロワー <span class="profile-follow-count">{{ $user->followers->count() }}</span></a>
            </div>
        </div>
        <div style="margin-top:32px;">
            <h2 style="font-size:1.15rem;color:#374151;margin-bottom:10px;font-weight:600;">投稿一覧</h2>
            @if ($user->posts->count() > 0)
            <div class="post-list-wrapper">
                @foreach ($user->posts as $post)
                <div class="post-item" style="background:#fff;border-radius:12px;padding:20px;margin-bottom:20px;box-shadow:0 4px 12px rgba(0,0,0,0.1);transition:all 0.3s;">
                    <a href="{{ route('posts.show', $post) }}" style="text-decoration:none;color:inherit;">
                        <div style="display:flex;align-items:center;gap:16px;">
                            @if ($post->image)
                            @if(Str::startsWith($post->image, 'http'))
                            <img src="{{ $post->image }}" alt="投稿画像" style="max-width:80px;border-radius:8px;">
                            @else
                            <img src="{{ asset('storage/' . ltrim($post->image, '/')) }}" alt="投稿画像" style="max-width:80px;border-radius:8px;">
                            @endif
                            @endif
                            <div>
                                <div style="font-size:1.1rem;font-weight:bold;">{{ $post->title }}</div>
                                <div style="color:#666;font-size:0.98rem;">
                                    <span>📍{{ optional($post->place)->name ?? '未設定' }}</span>
                                    @if ($post->work)
                                    <span style="margin-left:8px;">🎬{{ $post->work->name }}</span>
                                    @endif
                                    @if ($post->song)
                                    <span style="margin-left:8px;">🎵{{ $post->song->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <p style="color:#888;text-align:center;margin-top:24px;">投稿はまだありません。</p>
            @endif
        </div>
    </div>
    @endsection
</body>

</html>
<style>
    body {
        background: #f6f7fb;
    }

    .container {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.10);
        padding: 36px 28px 32px 28px;
        max-width: 520px;
    }

    h1 {
        font-size: 1.6rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 18px;
        letter-spacing: 0.03em;
        text-align: center;
    }

    .profile-follows {
        display: flex;
        gap: 24px;
        font-size: 1.08rem;
        margin-bottom: 18px;
        justify-content: center;
    }

    .profile-follow-link {
        color: #667eea;
        font-weight: bold;
        background: #f3f4f6;
        padding: 4px 14px;
        border-radius: 8px;
        transition: background 0.2s, color 0.2s;
    }

    .profile-follow-link:hover {
        background: #e0e7ff;
        color: #764ba2;
    }

    .profile-follow-count {
        margin-left: 2px;
        font-size: 1.13em;
    }

    h2 {
        font-size: 1.15rem;
        color: #374151;
        margin-top: 28px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    ul.list-disc {
        padding-left: 1.2em;
        margin-bottom: 0;
    }

    ul.list-disc li {
        margin-bottom: 7px;
        color: #444;
        font-size: 1.01rem;
    }

    p {
        color: #888;
        text-align: center;
        margin-top: 24px;
    }

    .follow-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        font-weight: bold;
        padding: 8px 22px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .follow-btn.following {
        background: #e0e7ff;
        color: #667eea;
    }
</style>