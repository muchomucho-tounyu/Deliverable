<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>follows</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    @if(Auth::user()->followings->contains($user->id))
    <form action="{{ route('user.unfollow', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">フォロー解除</button>
    </form>
    @else
    <form action="{{ route('user.follow', $user) }}" method="POST">
        @csrf
        <button type="submit">フォロー</button>
    </form>
    @endif
</body>