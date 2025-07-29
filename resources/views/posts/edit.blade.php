@extends("layouts.app")

@section("header")
<h1>投稿編集</h1>
@endsection

@section("content")
@php
use Illuminate\Support\Str;
@endphp

<div style="max-width: 800px; margin: 0 auto; padding: 20px; padding-top: 80px;">
    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 1.8rem; font-weight: bold; color: #1f2937; margin-bottom: 30px; text-align: center;">投稿を編集</h2>

        <form action="{{ route("posts.update", $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <!-- タイトル -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">タイトル *</label>
                <input type="text" name="title" value="{{ old("title", $post->title) }}" required
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
            </div>

            <!-- 作品名・楽曲名 -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">作品名</label>
                    <input type="text" name="work_name" value="{{ old("work_name", $post->work ? $post->work->name : "") }}"
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">楽曲名</label>
                    <input type="text" name="song_name" value="{{ old("song_name", $post->song ? $post->song->name : "") }}"
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
                </div>
            </div>

            <!-- 出演者名 -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">出演者・アーティスト名</label>
                <input type="text" name="person_name" value="{{ old("person_name", $post->people->isNotEmpty() ? $post->people->pluck("name")->join(", ") : "") }}"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
            </div>

            <!-- 場所名・住所 -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">場所名 *</label>
                    <input type="text" name="place_name" value="{{ old("place_name", $post->place ? $post->place->name : "") }}" required
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">住所 *</label>
                    <input type="text" name="address" value="{{ old("address", $post->place ? $post->place->address : "") }}" required
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">
                </div>
            </div>

            <!-- 画像 -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">新しい画像を選択</label>
                <input type="file" name="image" accept="image/*"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem;">

                @if($post->image_path)
                <div style="margin-top: 15px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <p style="font-weight: 600; margin-bottom: 10px;">現在の画像:</p>
                    @if(Str::startsWith($post->image_path, ["http://", "https://"]))
                    <img src="{{ $post->image_path }}" alt="現在の投稿画像" style="max-width: 200px; border-radius: 8px;">
                    @else
                    <img src="{{ asset($post->image_path) }}" alt="現在の投稿画像" style="max-width: 200px; border-radius: 8px;">
                    @endif
                </div>
                @endif
            </div>

            <!-- コメント -->
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">コメント</label>
                <textarea name="body" rows="4"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem; resize: vertical;">{{ old("body", $post->body) }}</textarea>
            </div>

            <!-- ボタン -->
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer;">更新する</button>
                <a href="{{ route("posts.show", $post)}}" style="background: #f3f4f6; color: #374151; border: 2px solid #e5e7eb; padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600; text-decoration: none;">キャンセル</a>
                <button type="button" onclick="deletePost({{ $post->id }})" style="background: #ef4444; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer;">削除</button>
            </div>
        </form>

        <!-- 削除フォーム -->
        <form action="{{ route("posts.destroy", $post) }}" id="form_{{ $post->id }}" method="POST" style="display: none;">
            @csrf
            @method("DELETE")
        </form>
    </div>
</div>

<script>
    function deletePost(id) {
        if (confirm("この投稿を削除しますか？
                削除すると復元できません。 ")) {
                document.getElementById(`form_${id}`).submit();
            }
        }
</script>

@endsection