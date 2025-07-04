<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <h1>聖地リスト</h1>
    <br>
    <a href='/posts/create'>create</a>
    <br>
    @foreach($posts as $post)
    <div class="post-item">
        <!-- 画像 -->
        @if($post->image_path)
        <img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" style="max-width: 200px;">
        @endif

        {{-- タイトル --}}
        <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>

        <!-- 場所名 -->
        <p>
            {{ $post->place->name ?? '未設定' }}
        </p>



        <!-- 作品名または楽曲名-->
        <p>

            @if($post->work)
            作品名：{{ $post->work->name }}
            @elseif($post->song)
            楽曲名：{{ $post->song->name }}
            @else
            なし
            @endif
        </p>
        <br>
    </div>
    @endforeach

    <!-- ページネーション -->
    {{ $posts->links() }}

</body>

</html>