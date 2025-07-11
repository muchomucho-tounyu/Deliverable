@extends('layouts.app')

@section('header')
<h1>聖地詳細</h1>
@endsection

@section('content')

<h1>{{ $post->title }}</h1>

@if ($post->image)
<div style="margin-bottom: 1em;">
    <img src="{{ $post->image }}" alt="投稿画像" style="max-width: 100%; height: auto;">
</div>
@elseif ($post->image_path)
<div style="margin-bottom: 1em;">
    <img src="{{ $post->image_path }}" alt="投稿画像" style="max-width: 100%; height: auto;">
</div>
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

<h3>コメント一覧</h3>
@foreach($post->comments as $comment)
<div>
    <strong>{{ $comment->user->name }}</strong>:
    <p>{{ $comment->body }}</p>
    <small>{{ $comment->created_at->format('Y/m/d H:i') }}</small>
</div>
@endforeach

<form action="{{ route('comments.store',$post) }}" method=POST>
    @csrf
    <textarea name="body" placeholder="コメントを書く" rows="3" required></textarea>
    <button type=submit>送信</button>
</form>


<div class="edit"><a href="/posts/{{ $post->id }}/edit">編集</a></div>


<p><a href="{{ route('posts.index') }}">一覧へ戻る</a></p>

@endsection