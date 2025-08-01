@extends('layouts.app')

@section('header')
<h1>聖地詳細</h1>
@endsection

@section('content')
<div class="pt-32">
    <style>
        .comment-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 32px 24px;
            margin-top: 40px;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .comment-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 20px;
        }

        .comment-list {
            margin-bottom: 30px;
        }

        .comment-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.07);
        }

        .comment-user {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .comment-body {
            color: #333;
            margin-bottom: 6px;
            white-space: pre-line;
        }

        .comment-date {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .comment-form {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.07);
        }

        .comment-form textarea {
            width: 100%;
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            padding: 10px 14px;
            font-size: 1rem;
            margin-bottom: 12px;
            background: #fff;
            transition: border-color 0.2s;
        }

        .comment-form textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .comment-form button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .comment-form button:hover {
            background: #667eea;
            transform: translateY(-2px);
        }
    </style>
    <style>
        .show-wrapper {
            padding-top: 80px;
            max-width: 800px;
            margin: 0 auto 40px auto;
        }

        .show-card {
            background: white;
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
            margin-bottom: 40px;
        }

        .show-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 18px;
        }

        .show-image {
            max-width: 350px;
            border-radius: 10px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
        }

        .show-info {
            color: #555;
            margin-bottom: 18px;
            font-size: 1.08rem;
        }

        .show-info strong {
            color: #374151;
            margin-right: 6px;
        }

        .show-actions {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-bottom: 18px;
        }

        .show-action-btn {
            background: none;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .show-action-btn.favorited {
            color: #e53e3e;
        }

        .show-action-btn.visited {
            color: #38a169;
        }

        .show-action-btn:hover {
            background: #f3f4f6;
        }

        .show-edit-link {
            display: inline-block;
            margin-top: 10px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px solid #667eea;
            transition: color 0.2s;
        }

        .show-edit-link:hover {
            color: #764ba2;
        }

        .show-back-link {
            display: block;
            margin-top: 24px;
            color: #6b7280;
            text-align: right;
            text-decoration: underline;
            font-size: 1rem;
        }
    </style>
    {{-- 一覧に戻るボタンを左上・ヘッダー下に配置 --}}
    <div style="max-width:800px;margin:0 auto 16px auto;">
        <a href="{{ route('posts.index') }}" style="display:inline-block;background:#f3f4f6;color:#667eea;font-weight:bold;padding:8px 18px;border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(102,126,234,0.08);margin-top:8px;">
            b 一覧に戻る</a>
    </div>
    <div class="show-wrapper">
        <div class="show-card" style="position:relative;">
            <!-- 投稿者アイコン＋名前（タイトルの左横に並べる） -->
            <div class="show-header-row">
                <a href="{{ route('profile.show', $post->user->id) }}" class="show-user-link">
                    @if($post->user->image)
                    @if(Str::startsWith($post->user->image, ['http://', 'https://']))
                    <img src="{{ $post->user->image }}" class="show-user-avatar" alt="ユーザーアイコン">
                    @else
                    <img src="{{ asset($post->user->image) }}" class="show-user-avatar" alt="ユーザーアイコン">
                    @endif
                    @else
                    <img src="{{ asset('images/default-user.png') }}" class="show-user-avatar" alt="デフォルトアイコン">
                    @endif
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
            @if ($post->image_path)
            @if(Str::startsWith($post->image_path, ['http://', 'https://']))
            <img src="{{ $post->image_path }}" alt="投稿画像" class="show-image">
            @else
            <img src="{{ asset($post->image_path) }}" alt="投稿画像" class="show-image">
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
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .show-user-link {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #667eea;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        background: rgba(102, 126, 234, 0.1);
        transition: all 0.2s;
    }

    .show-user-link:hover {
        background: rgba(102, 126, 234, 0.2);
        transform: translateY(-1px);
    }

    .show-user-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .show-user-name {
        font-size: 0.95rem;
    }

    .show-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0;
        letter-spacing: 0.02em;
    }
</style>