<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>プロフィールページ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $user->name }}さんのプロフィール</h1>

        <div class="mb-4">
            <strong>メールアドレス:</strong> {{ $user->email }}
        </div>

        <div class="mb-4">
            <strong>登録日:</strong> {{ $user->created_at->format('Y年m月d日') }}
        </div>

        <!-- もし投稿一覧も表示したいなら -->
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