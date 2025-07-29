@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 70px 20px 28px;
        position: relative;
        border-radius: 0 0 24px 24px;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.10);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .profile-info {
        text-align: center;
        margin-bottom: 8px;
    }

    .profile-name {
        font-size: 1.7rem;
        font-weight: bold;
        margin-bottom: 7px;
        letter-spacing: 0.03em;
    }

    .profile-details {
        font-size: 1rem;
        opacity: 0.92;
        margin-bottom: 10px;
    }

    .profile-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-edit {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .btn-logout {
        background: rgba(239, 68, 68, 0.8);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 1);
        transform: translateY(-1px);
    }

    .tab-container {
        background: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .tab-nav {
        display: flex;
        max-width: 600px;
        margin: 0 auto;
    }

    .tab-button {
        flex: 1;
        padding: 15px;
        text-align: center;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .tab-button.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }

    .tab-button:hover {
        background: #f9fafb;
    }

    .tab-content {
        display: none;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
    }

    .tab-content.active {
        display: block;
    }

    .post-item {
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 0;
        transition: all 0.3s ease;
    }

    .post-item:hover {
        background: #f9fafb;
        padding-left: 10px;
        border-radius: 8px;
    }

    .post-title {
        font-weight: 600;
        color: #1f2937;
        text-decoration: none;
        font-size: 1rem;
    }

    .post-title:hover {
        color: #667eea;
    }

    .post-meta {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 5px;
    }

    .post-image {
        max-width: 150px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .edit-form {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 20px auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-button {
        background: #667eea;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-button:hover {
        background: #5a67d8;
        transform: translateY(-1px);
    }

    .profile-follows {
        display: flex;
        gap: 24px;
        justify-content: center;
        margin-bottom: 8px;
        font-size: 1.12rem;
    }

    .profile-follow-link {
        cursor: pointer;
        color: #fff;
        font-weight: bold;
        transition: color 0.2s;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.10);
        padding: 2px 8px;
        border-radius: 8px;
    }

    .profile-follow-link:hover {
        color: #ffe066;
        background: rgba(255, 255, 255, 0.10);
        text-decoration: underline;
    }

    .profile-follow-count {
        margin-left: 2px;
        font-size: 1.13em;
    }

    .profile-bio {
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
        border-radius: 12px;
        padding: 16px 22px;
        margin: 16px auto 0 auto;
        max-width: 440px;
        font-size: 1.08rem;
        text-align: center;
        white-space: pre-line;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
        letter-spacing: 0.01em;
        line-height: 1.7;
    }
</style>

@if(request()->query('edit') == 1)
<!-- 編集モード -->
<div class="edit-form">
    <h2 class="text-xl font-bold mb-6 text-center">プロフィール編集</h2>
    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="age" class="form-label">年齢</label>
            <input type="number" name="age" id="age" value="{{ old('age', $user->age) }}" class="form-input" min="0" max="150">
        </div>

        <div class="form-group">
            <label for="sex" class="form-label">性別</label>
            <select name="sex" id="sex" class="form-input">
                <option value="">未設定</option>
                <option value="male" @if(old('sex', $user->sex)==='male') selected @endif>男性</option>
                <option value="female" @if(old('sex', $user->sex)==='female') selected @endif>女性</option>
                <option value="other" @if(old('sex', $user->sex)==='other') selected @endif>その他</option>
            </select>
        </div>

        <div class="form-group">
            <label for="bio" class="form-label">自己紹介文</label>
            <textarea name="bio" id="bio" class="form-input" rows="4" maxlength="1000">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">プロフィール画像</label>
            <input type="file" name="image" id="image" accept="image/*" class="form-input">
            @if($user->image)
            <div class="mt-2">
                <img src="{{ $user->image }}" alt="現在のプロフィール画像" style="width:60px; height:60px; border-radius:50%; object-fit:cover;">
            </div>
            @endif
        </div>

        <div class="flex gap-3">
            <button type="submit" class="form-button flex-1">保存</button>
            <a href="{{ route('mypage') }}" class="form-button flex-1 text-center" style="background: #6b7280; text-decoration: none;">キャンセル</a>
        </div>
    </form>
</div>
@else
<!-- 表示モード -->
<div class="profile-header">
    <div class="profile-info">
        @if($user->image)
        @if(Str::startsWith($user->image, ['http://', 'https://']))
        <img src="{{ $user->image }}" alt="プロフィール画像" class="profile-avatar">
        @else
        <img src="{{ asset($user->image) }}" alt="プロフィール画像" class="profile-avatar">
        @endif
        @else
        <img src="{{ asset('images/default-user.png') }}" alt="デフォルトプロフィール画像" class="profile-avatar">
        @endif


        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-details">
            @if($user->age || $user->sex)
            {{ $user->age ?? '' }}{{ $user->age && $user->sex ? '歳・' : '' }}
            @if($user->sex === 'male')
            男性
            @elseif($user->sex === 'female')
            女性
            @elseif($user->sex === 'other')
            その他
            @endif
            @endif
            {{ $user->age || $user->sex ? '・' : '' }}{{ $user->created_at->format('Y年m月') }}から利用中
        </div>
        @if($user->bio)
        <div class="profile-bio mt-3 p-3 bg-white bg-opacity-10 rounded-lg text-sm">
            {{ $user->bio }}
        </div>
        @endif

        <div class="profile-follows">
            <span class="profile-follow-link" onclick="openFollowModal('followings')">フォロー <span class="profile-follow-count">{{ $user->followings->count() }}</span></span>
            <span class="profile-follow-link" onclick="openFollowModal('followers')">フォロワー <span class="profile-follow-count">{{ $user->followers->count() }}</span></span>
        </div>

        <div class="profile-actions">
            <a href="{{ route('mypage', ['edit' => 1]) }}" class="btn-edit">プロフィール編集</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">ログアウト</button>
            </form>
        </div>
    </div>
</div>

<div class="tab-container">
    <div class="tab-nav">
        <button class="tab-button active" onclick="showTab('posts')">📌 投稿 ({{ $user->posts->count() }})</button>
        <button class="tab-button" onclick="showTab('favorites')">❤️ いいね ({{ $user->favorites->count() }})</button>
        <button class="tab-button" onclick="showTab('visits')">🏁 訪問済み ({{ $user->visits->count() }})</button>
    </div>
</div>

<!-- 投稿タブ -->
<div id="posts" class="tab-content active">
    @forelse($user->posts as $post)
    <div class="post-item">
        {{-- 投稿画像表示部分 --}}
        @if ($post->image_path)
        @if(Str::startsWith($post->image_path, ['http://', 'https://']))
        <img src="{{ $post->image_path }}" alt="投稿画像" class="post-image">
        @else
        <img src="{{ asset($post->image_path) }}" alt="投稿画像" class="post-image">
        @endif
        @endif

        <a href="{{ route('posts.show', $post->id) }}" class="post-title">{{ $post->title }}</a>
        <div class="post-meta">{{ $post->created_at->format('Y年m月d日') }}</div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon">📝</div>
        <p>まだ投稿がありません</p>
        <a href="{{ route('posts.create') }}" class="btn-edit" style="margin-top: 10px; display: inline-block;">投稿してみる</a>
    </div>
    @endforelse
</div>

<!-- いいねタブ -->
<div id="favorites" class="tab-content">
    @forelse($user->favorites as $post)
    <div class="post-item">
        {{-- 投稿画像表示部分 --}}
        @if ($post->image_path)
        @if(Str::startsWith($post->image_path, ['http://', 'https://']))
        <img src="{{ $post->image_path }}" alt="投稿画像" class="post-image">
        @else
        <img src="{{ asset($post->image_path) }}" alt="投稿画像" class="post-image">
        @endif
        @endif

        <a href="{{ route('posts.show', $post->id) }}" class="post-title">{{ $post->title }}</a>
        <div class="post-meta">by {{ $post->user->name }} • {{ $post->created_at->format('Y年m月d日') }}</div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon">❤️</div>
        <p>まだいいねした投稿がありません</p>
    </div>
    @endforelse
</div>

<!-- 訪問済みタブ -->
<div id="visits" class="tab-content">
    @forelse($user->visits as $post)
    <div class="post-item">
        {{-- 投稿画像表示部分 --}}
        @if ($post->image_path)
        @if(Str::startsWith($post->image_path, ['http://', 'https://']))
        <img src="{{ $post->image_path }}" alt="投稿画像" class="post-image">
        @else
        <img src="{{ asset($post->image_path) }}" alt="投稿画像" class="post-image">
        @endif
        @endif

        <a href="{{ route('posts.show', $post->id) }}" class="post-title">{{ $post->title }}</a>
        <div class="post-meta">訪問日: {{ $post->pivot->created_at->format('Y年m月d日 H:i') }}</div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon">🏁</div>
        <p>まだ訪問した投稿がありません</p>
    </div>
    @endforelse
</div>

<script>
    function showTab(tabName) {
        // すべてのタブコンテンツを非表示
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.classList.remove('active'));

        // すべてのタブボタンからactiveクラスを削除
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => button.classList.remove('active'));

        // 選択されたタブを表示
        document.getElementById(tabName).classList.add('active');

        // クリックされたボタンにactiveクラスを追加
        event.target.classList.add('active');
    }
</script>
<script>
    function openFollowModal(type) {
        alert(type + '一覧モーダル（ここに実装予定）');
    }
</script>
@endif
@endsection