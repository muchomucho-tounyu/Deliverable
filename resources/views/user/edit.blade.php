@extends('layouts.app')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold mb-6">プロフィール編集</h1>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 名前 -->
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">名前<span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full border rounded px-3 py-2">
        </div>

        <!-- メール -->
        <div class="mb-4">
            <label for="email" class="block font-semibold mb-1">メールアドレス<span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                class="w-full border rounded px-3 py-2">
        </div>

        <!-- 年齢 -->
        <div class="mb-4">
            <label for="age" class="block font-semibold mb-1">年齢</label>
            <input type="number" id="age" name="age" value="{{ old('age', $user->age) }}"
                class="w-full border rounded px-3 py-2" min="0">
        </div>

        <!-- 性別 -->
        <div class="mb-4">
            <label for="sex" class="block font-semibold mb-1">性別</label>
            <select id="sex" name="sex" class="w-full border rounded px-3 py-2">
                <option value="" {{ old('sex', $user->sex) == '' ? 'selected' : '' }}>選択してください</option>
                <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>男性</option>
                <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>女性</option>
                <option value="other" {{ old('sex', $user->sex) == 'other' ? 'selected' : '' }}>その他</option>
            </select>
        </div>

        <!-- 自己紹介 -->
        <div class="mb-4">
            <label for="bio" class="block font-semibold mb-1">自己紹介</label>
            <textarea id="bio" name="bio" rows="4" placeholder="自己紹介を入力してください（最大1000文字）"
                class="w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <!-- 画像 -->
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">プロフィール画像</label>
            @if($user->image)
            <div class="mb-2">
                @php
                $isCloudinary = (substr($user->image, 0, 4) === 'http');
                @endphp
                @if($isCloudinary)
                <img src="{{ $user->image }}" alt="プロフィール画像" class="w-24 h-24 object-cover rounded-full">
                @else
                <img src="{{ asset('storage/' . ltrim($user->image, '/')) }}" alt="プロフィール画像" class="w-24 h-24 object-cover rounded-full">
                @endif
            </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*" class="w-full">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            更新する
        </button>
    </form>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const imageFile = document.getElementById('image').files[0];

        if (imageFile) {
            formData.set('image', imageFile);
            console.log('Image file selected:', imageFile.name, imageFile.size);
        }

        fetch('{{ route("user.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.text())
            .then(data => {
                console.log('Response:', data);
                window.location.href = '{{ route("mypage") }}';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
@endsection