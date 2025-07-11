@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $user->name }} さんのマイページ</h1>

    <div class="bg-white rounded shadow p-6 mb-6">
        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block font-semibold">名前</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="border rounded px-2 py-1 w-full">
            </div>
            <div>
                <label for="email" class="block font-semibold">メール</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="border rounded px-2 py-1 w-full">
            </div>
            <div>
                <label for="age" class="block font-semibold">年齢</label>
                <input type="number" name="age" id="age" value="{{ old('age', $user->age) }}" class="border rounded px-2 py-1 w-full">
            </div>
            <div>
                <label for="sex" class="block font-semibold">性別</label>
                <select name="sex" id="sex" class="border rounded px-2 py-1 w-full">
                    <option value="">未設定</option>
                    <option value="male" @if(old('sex', $user->sex)==='male') selected @endif>男性</option>
                    <option value="female" @if(old('sex', $user->sex)==='female') selected @endif>女性</option>
                    <option value="other" @if(old('sex', $user->sex)==='other') selected @endif>その他</option>
                </select>
            </div>
            <div>
                <label for="image" class="block font-semibold">プロフィール画像</label>
                <input type="file" name="image" id="image" accept="image/*" class="border rounded px-2 py-1 w-full">
                @if($user->image)
                <img src="{{ $user->image }}" alt="プロフィール画像" style="width:80px; height:80px; border-radius:50%; margin-top:8px;">
                @endif
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">ログアウト</button>
        </form>
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
        <p>URL: {{ route('posts.show', $post->id) }}</p>
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