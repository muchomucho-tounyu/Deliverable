@extends('layouts.app')

@section('header')
<h2>聖地作成</h2>
@endsection

@section('content')
<!--エラーメッセージ-->
@if ($errors->any())
<div class="errors" style="color:red; margin-bottom:1em;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>タイトル：</label>
    <input type="text" name="title" required>
    <br>
    <br>

    <label>作品名：</label>
    <input type="text" name="work_name" value="{{ old('work_name') }}">
    <br>
    <br>

    <label>楽曲名：</label>
    <input type="text" name="song_name" value="{{ old('song_name') }}">
    <br>
    <br>

    <label>出演者・アーティスト名：</label>
    <input type="text" name="person_name">
    <br>
    <br>

    <label>場所名：</label>
    <input type="text" name="place_name" required>
    <br>
    <br>

    <label>住所：</label>
    <input type="text" name="address" required>
    <br>
    <br>

    <label>画像</label>
    <input type="file" name="image_path">
    <br>
    <br>

    <label>コメント：</label>
    <textarea name="body" rows="4"></textarea>
    <br>
    <br>


    <button type="submit">投稿する</button>
</form>

<br>

<p><a href="{{ route('posts.index') }}">一覧へ戻る</a></p>

@endsection