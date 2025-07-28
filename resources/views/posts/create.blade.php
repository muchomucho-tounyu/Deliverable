@extends('layouts.app')

@section('header')
<h2>聖地作成</h2>
@endsection

@section('content')
<style>
    .create-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .create-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .create-title {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .create-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }

    .create-form {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f3f4f6;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
        resize: vertical;
        min-height: 120px;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-file {
        width: 100%;
        padding: 12px 16px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-file:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .form-file:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .error-message {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error-list {
        margin: 0;
        padding-left: 20px;
    }

    .error-list li {
        margin-bottom: 5px;
    }

    .field-hint {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .create-form {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="create-container">
    <div class="create-header">
        <h1 class="create-title">🏛️ 新しい聖地を投稿</h1>
        <p class="create-subtitle">あなたが訪れた聖地の思い出を共有しましょう</p>
    </div>

    <!--エラーメッセージ-->
    @if ($errors->any())
    <div class="error-message">
        <ul class="error-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
        @csrf

        <!-- 基本情報セクション -->
        <div class="form-section">
            <h3 class="section-title">📝 基本情報</h3>

            <div class="form-group">
                <label for="title" class="form-label">タイトル<span class="required">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-input" required placeholder="聖地のタイトルを入力">
                <div class="field-hint">例：君の名は。の階段、鬼滅の刃の浅草寺、楽曲の聖地など</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="work_name" class="form-label">作品名</label>
                    <input type="text" name="work_name" id="work_name" value="{{ old('work_name') }}" class="form-input" placeholder="アニメ・映画・ドラマ名">
                    <div class="field-hint">作品名を入力すると、テーマソングの項目が表示されます</div>
                </div>

                <div class="form-group" id="song_name_group" style="display: none;">
                    <label for="song_name" class="form-label">テーマソング</label>
                    <input type="text" name="song_name" id="song_name" value="{{ old('song_name') }}" class="form-input" placeholder="テーマソング・挿入歌・エンディング曲など">
                    <div class="field-hint">作品のテーマソングや印象的な楽曲があれば入力してください</div>
                </div>
            </div>

            <div class="form-group">
                <label for="person_name" class="form-label">出演者・アーティスト名</label>
                <input type="text" name="person_name" id="person_name" value="{{ old('person_name') }}" class="form-input" placeholder="声優・俳優・アーティスト名">
            </div>
        </div>

        <!-- 場所情報セクション -->
        <div class="form-section">
            <h3 class="section-title">📍 場所情報</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="place_name" class="form-label">場所名<span class="required">*</span></label>
                    <input type="text" name="place_name" id="place_name" value="{{ old('place_name') }}" class="form-input" required placeholder="施設名・地名">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">住所<span class="required">*</span></label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-input" required placeholder="都道府県市区町村">
                </div>
            </div>
        </div>

        <!-- メディアセクション -->
        <div class="form-section">
            <h3 class="section-title">📸 写真・メディア</h3>

            <div class="form-group">
                <label for="image" class="form-label">画像アップロード</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-file">
                <div class="field-hint">JPG、PNG形式、最大2MBまで</div>
            </div>
        </div>

        <!-- コメントセクション -->
        <div class="form-section">
            <h3 class="section-title">💭 コメント・思い出</h3>

            <div class="form-group">
                <label for="body" class="form-label">コメント</label>
                <textarea name="body" id="body" class="form-textarea" placeholder="聖地巡礼の思い出や感想を自由に書いてください">{{ old('body') }}</textarea>
                <div class="field-hint">訪問した時の様子、撮影スポットの情報、おすすめの時間帯など</div>
            </div>
        </div>

        <!-- アクションボタン -->
        <div class="form-actions">
            <button type="submit" class="btn-primary">
                🚀 投稿する
            </button>
            <a href="{{ route('posts.index') }}" class="btn-secondary">
                ← 一覧に戻る
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const workNameInput = document.getElementById('work_name');
        const songNameInput = document.getElementById('song_name');
        const songNameGroup = document.getElementById('song_name_group');

        // 作品名が入力された時の処理
        function handleWorkInput() {
            const hasWorkName = workNameInput.value.trim() !== '';

            // 作品名が入力されている場合、テーマソング項目を表示
            if (hasWorkName) {
                songNameGroup.style.display = 'block';
                songNameGroup.style.backgroundColor = '#f0f4ff';
                songNameGroup.style.border = '2px solid #667eea';
                songNameGroup.style.borderRadius = '8px';
                songNameGroup.style.padding = '10px';
                songNameGroup.style.marginTop = '10px';
            } else {
                songNameGroup.style.display = 'none';
                songNameGroup.style.backgroundColor = '';
                songNameGroup.style.border = '';
                songNameGroup.style.borderRadius = '';
                songNameGroup.style.padding = '';
                songNameGroup.style.marginTop = '';
                // 作品名が削除された場合、テーマソングの入力もクリア
                songNameInput.value = '';
            }
        }

        // イベントリスナーを追加
        workNameInput.addEventListener('input', handleWorkInput);

        // 初期状態を設定
        handleWorkInput();
    });
</script>
@endsection