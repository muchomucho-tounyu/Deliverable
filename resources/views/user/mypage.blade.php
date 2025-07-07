@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $user->name }} さんのマイページ</h1>

    <div class="bg-white rounded shadow p-6 mb-6">
        <p><strong>名前:</strong> {{ $user->name }}</p>
        <p><strong>メール:</strong> {{ $user->email }}</p>
        <p><strong>登録日:</strong> {{ $user->created_at->format('Y年m月d日') }}</p>
        <p><strong>フォロー中:</strong> {{ $user->followings->count() }}</p>
        <p><strong>フォロワー:</strong> {{ $user->followers->count() }}</p>

        <div class="edit"><a href="/mypage/{{ $user->id }}/edit">編集</a></div>
    </div>

    <!-- 投稿一覧 -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">📌 あなたの投稿</h2>
        @forelse($user->posts as $post)
        <div class="border-b py-2">
            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">{{ $post->title }}</a>
            <p class="text-sm text-gray-600">投稿日: {{ $post->created_at->format('Y/m/d') }}</p>
        </div>
        @empty
        <p class="text-gray-500">投稿はありません。</p>
        @endforelse
    </div>

    <!-- お気に入り一覧 -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">❤️ お気に入り</h2>
        @forelse($user->favorites as $post)
        <div class="border-b py-2">
            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">{{ $post->title }}</a>
            <p class="text-sm text-gray-600">投稿者: {{ $post->user->name }}</p>
        </div>
        @empty
        <p class="text-gray-500">お気に入りはまだありません。</p>
        @endforelse
    </div>

    <!-- 訪問済み一覧 -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">👣 訪問済みページ</h2>
        @forelse($user->visits as $post)
        <div class="border-b py-2">
            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">{{ $post->title }}</a>
            <p class="text-sm text-gray-600">訪問日: {{ $post->pivot->created_at->format('Y/m/d H:i') }}</p>
        </div>
        @empty
        <p class="text-gray-500">訪問履歴はありません。</p>
        @endforelse
    </div>
</div>
@endsection