<h1>{{ $post->title }}</h1>

@if($post->image_path)
<img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" style="max-width: 400px;">
@endif

<p>内容: {{ $post->content }}</p>

<p>場所: {{ $post->place ? $post->place->name : 'なし' }}</p>

<p>作品: {{ $post->work ? $post->work->title : 'なし' }}</p>
<p>楽曲: {{ $post->song ? $post->song->title : 'なし' }}</p>

{{-- 必要なら他の情報もここに --}}