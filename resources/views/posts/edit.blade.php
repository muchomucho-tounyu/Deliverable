<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>投稿編集</title>
</head>

<body>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <form action="/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label>タイトル：</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
            <br><br>

            <label>作品名：</label>
            <input type="text" name="work_name" value="{{ old('work_name', $post->work ? $post->work->name : '') }}">
            <br><br>

            <label>楽曲名：</label>
            <input type="text" name="song_name" value="{{ old('song_name', $post->song ? $post->song->name : '') }}">
            <br><br>

            <label>出演者・アーティスト名：</label>
            <input type="text" name="person_name" value="{{ old('person_name') }}">
            <br><br>

            <label>場所名：</label>
            <input type="text" name="place_name" value="{{ old('place_name', $post->place ? $post->place->name : '') }}" required>
            <br><br>

            <label>住所：</label>
            <input type="text" name="address" value="{{ old('address', $post->place ? $post->place->address : '') }}" required>
            <br><br>

            <label>画像：</label>
            <input type="file" name="image_path">
            @if($post->image_path)
            <div>
                <p>現在の画像:</p>
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" style="max-width: 200px;">
            </div>
            @endif
            <br><br>

            <label>コメント：</label>
            <textarea name="body" rows="4">{{ old('body', $post->body) }}</textarea>
            <br><br>

            <input type="submit" value="更新">
        </form>
    </div>

    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
        @csrf
        @method('DELETE')
        <button type="button" onclick="deletePost({{ $post->id }})">delete</button>
    </form>

    <p><a href="{{ route('posts.index') }}">一覧へ戻る</a></p>

    <script>
        function deletePost(id) {
            'use strict'

            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>

</body>

</html>