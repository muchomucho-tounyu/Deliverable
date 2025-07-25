@extends('layouts.app')

@section('header')
<h1>聖地詳細</h1>
@endsection

@section('content')
{{-- 一覧に戻るボタンを左上・ヘッダー下に配置 --}}
<div style="max-width:800px;margin:0 auto 16px auto;">
    <a href="{{ route('posts.index') }}" style="display:inline-block;background:#f3f4f6;color:#667eea;font-weight:bold;padding:8px 18px;border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(102,126,234,0.08);margin-top:8px;">
        b 一覧に戻る</a>
</div>
<div class="show-wrapper">
    <div class="show-card" style="position:relative;">
        <!-- 投稿者アイコン＋名前（タイトルの左横に並べる） -->
        <div class="show-header-row">
            <a href="{{ url('/profile/'.$post->user->id) }}" class="show-user-link">
                <img src="{{ $post->user->image ? asset('storage/' . ltrim($post->user->image, '/')) : asset('images/default-user.png') }}" class="show-user-avatar" alt="ユーザーアイコン">
                <span class="show-user-name">{{ $post->user->name }}</span>
            </a>
            <span class="show-title">{{ $post->title }}</span>
        </div>
        @if(auth()->check() && auth()->id() === $post->user_id)
        <!-- 編集・削除ボタン（投稿者本人のみ表示） -->
        <a href="/posts/{{ $post->id }}/edit" class="show-edit-fab" title="編集">
            ✏️
        </a>
        <form action="/posts/{{ $post->id }}" method="POST" class="show-delete-fab" onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" title="削除" style="background:none;border:none;padding:0;cursor:pointer;font-size:1.5rem;">🗑️</button>
        </form>
        @endif
        @if ($post->image)
        @if(Str::startsWith($post->image, 'http'))
        <img src="{{ $post->image }}" alt="投稿画像" class="show-image">
        @else
        <img src="{{ asset('storage/' . ltrim($post->image, '/')) }}" alt="投稿画像" class="show-image">
        @endif
        @endif
        <div class="show-info">
            @if ($post->work)
            <div><strong>🎬 作品名:</strong>{{ $post->work->name }}</div>
            @if ($post->work->overview)
            <div><strong>📝 あらすじ:</strong>{{ $post->work->overview }}</div>
            @endif
            @if ($post->work->trailer_url)
            <div><strong>🎞️ 予告編:</strong><a href="{{ $post->work->trailer_url }}" target="_blank" style="color:#667eea;">動画を見る</a></div>
            @endif
            @if ($post->work->official_site)
            <div><strong>🔗 公式サイト:</strong><a href="{{ $post->work->official_site }}" target="_blank" style="color:#667eea;">リンク</a></div>
            @endif
            @endif
            @if ($post->song)
            <div><strong>🎵 楽曲名:</strong>{{ $post->song->name }}</div>
            @if ($post->song->mv_url)
            <div><strong>🎬 MV:</strong><a href="{{ $post->song->mv_url }}" target="_blank" style="color:#667eea;">MVを見る</a></div>
            @endif
            @endif
            @if ($post->people && $post->people->isNotEmpty())
            <div><strong>👤 出演者・アーティスト名:</strong>{{ $post->people->pluck('name')->join(', ') }}</div>
            @else
            <div><strong>👤 出演者・アーティスト名:</strong>未設定</div>
            @endif
            <div><strong>📍 場所名:</strong>{{ optional($post->place)->name ?? '未設定' }}</div>
            <div><strong>🏠 住所:</strong>{{ optional($post->place)->address ?? '不明' }}</div>
            <div><strong>🎬 ロケシーン:</strong>{{ $post->place_detail ?? 'なし' }}</div>
            <div><strong>📝 コメント:</strong><br>{!! nl2br(e($post->body)) ?? 'コメントなし' !!}</div>
            <div><strong>🧑 投稿者:</strong>{{ $post->user->name ?? '不明' }}</div>
            <div><strong>🕒 投稿日:</strong>{{ $post->created_at->format('Y/m/d H:i') }}</div>
        </div>
        <div class="show-actions">
            <form action="{{ route('posts.favorite', $post) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="show-action-btn {{ auth()->check() && auth()->user()->hasFavorited($post) ? 'favorited' : '' }}" title="いいね">
                    @if(auth()->check() && auth()->user()->hasFavorited($post)) ❤️ @else 🤍 @endif
                </button>
            </form>
            <form action="{{ route('posts.visit', $post) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="show-action-btn {{ auth()->check() && auth()->user()->hasVisited($post) ? 'visited' : '' }}" title="訪問済み">
                    @if(auth()->check() && auth()->user()->hasVisited($post)) 👣 @else ☁️ @endif
                </button>
            </form>
        </div>
    </div>
    <div class="comment-section">
        <div class="comment-title">コメント一覧</div>
        <div class="comment-list">
            @forelse($post->comments as $comment)
            <div class="comment-card">
                <div class="comment-user">
                    <a href="{{ route('profile.show', ['id' => $comment->user->id]) }}">
                        {{ $comment->user->name }}
                    </a>
                </div>
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
</div>
@endsection

<style>
    .show-edit-fab {
        position: absolute;
        top: 18px;
        right: 68px;
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        z-index: 10;
        transition: background 0.2s, transform 0.2s;
        border: none;
        text-decoration: none;
    }

    .show-edit-fab:hover {
        background: #667eea;
        transform: scale(1.08);
        color: #fff;
        text-decoration: none;
    }

    .show-delete-fab {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .show-delete-fab button:hover {
        color: #e53e3e;
        transform: scale(1.08);
    }

    .show-header-row {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 18px;
    }

    .show-user-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        transition: color 0.2s;
    }

    .show-user-link:hover {
        color: #667eea;
    }

    .show-user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 8px;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
        background: #f3f4f6;
    }

    .show-user-name {
        font-size: 1.02rem;
        font-weight: bold;
        margin-right: 2px;
    }

    .show-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0;
        letter-spacing: 0.02em;
    }
</style>