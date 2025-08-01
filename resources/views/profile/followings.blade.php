@extends('layouts.app')
@section('header')
<h1>{{ $user->name }}さんのフォロー一覧</h1>
@endsection
@section('content')
<div style="max-width:520px;margin:0 auto;">
    @if($followings->count() > 0)
    <ul style="padding:0;list-style:none;">
        @foreach($followings as $following)
        <li style="background:#fff;border-radius:12px;padding:18px 20px;margin-bottom:16px;box-shadow:0 2px 8px rgba(102,126,234,0.08);display:flex;align-items:center;gap:16px;">
            <a href="{{ route('profile.show', $following->id) }}" style="display:flex;align-items:center;text-decoration:none;color:#333;gap:12px;">
                <img src="{{ $following->image ? asset('storage/' . ltrim($following->image, '/')) : asset('images/default-user.png') }}" alt="ユーザー画像" style="width:48px;height:48px;border-radius:50%;object-fit:cover;background:#f3f4f6;">
                <span style="font-weight:bold;font-size:1.1rem;">{{ $following->name }}</span>
            </a>
        </li>
        @endforeach
    </ul>
    @else
    <p style="color:#888;text-align:center;margin-top:24px;">フォローしているユーザーはいません。</p>
    @endif
    <div style="text-align:center;margin-top:24px;">
        <a href="{{ route('profile.show', $user->id) }}" style="color:#667eea;text-decoration:underline;">← プロフィールに戻る</a>
    </div>
</div>
@endsection