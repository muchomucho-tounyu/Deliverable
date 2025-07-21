<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>プロフィールページ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $user->name }}</h1>
        <div class="profile-follows mb-4">
            <span class="profile-follow-link">フォロー <span class="profile-follow-count">{{ $user->followings->count() }}</span></span>
            <span class="profile-follow-link">フォロワー <span class="profile-follow-count">{{ $user->followers->count() }}</span></span>
        </div>
        @if ($user->posts->count() > 0)
        <h2 class="text-xl font-semibold mt-6 mb-2">投稿一覧</h2>
        <ul class="list-disc list-inside">
            @foreach ($user->posts as $post)
            <li>{{ $post->title }}</li>
            @endforeach
        </ul>
        @else
        <p>投稿はまだありません。</p>
        @endif
    </div>
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
</style>