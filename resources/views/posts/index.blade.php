@extends('layouts.app')

@section('header')
<h1>聖地一覧</h1>
@endsection

@section('content')
<h1>聖地リスト</h1>

<form method="GET" action="{{ route('posts.index') }}">
    <input type="text" name="keyword" placeholder="キーワードで検索" value="{{ request('keyword') }}">
    <button type="submit">検索</button>

</form>


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
        @if ($post->work)
    <p>作品名：{{ $post->work->name }}</p>
    @endif

    @if ($post->song)
    <p>楽曲名：{{ $post->song->name }}</p>
    @endif

    </p>
    <br>
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
</div>
@endforeach

<!-- ページネーション -->
{{ $posts->links() }}
@endsection