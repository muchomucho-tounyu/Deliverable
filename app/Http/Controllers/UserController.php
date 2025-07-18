<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        if ($user) {
            $user->load([
                'posts',
                'favorites',
                'favorites.user',
                'visits'
            ]);
        }
        return view('user.mypage', compact('user')); //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Cloudinary設定値をログ出力
        \Log::info('cloudinary config', [
            'cloud_name' => config('cloudinary.cloud_name'),
            'api_key' => config('cloudinary.api_key'),
            'api_secret' => config('cloudinary.api_secret'),
            'url' => config('cloudinary.url'),
        ]);
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user) {
            abort(403); // 認証済みじゃなければ403のエラーを出す
        }
        // バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'age' => ['nullable', 'integer', 'min:0'],
            'sex' => ['nullable', 'in:male,female,other'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // プロフィール画像アップロード（画像が選択された場合のみ）
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file && $file->isValid() && $file->getRealPath() && $file->getSize() > 0) {
                try {
                    // Cloudinaryへアップロード
                    $imageUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($file->getRealPath())->getSecurePath();
                    $validated['image'] = $imageUrl;
                    \Log::info('Cloudinary画像URL: ' . $imageUrl);
                } catch (\Exception $e) {
                    \Log::error('Cloudinaryアップロードエラー: ' . $e->getMessage());
                    // Cloudinaryアップロード失敗時はエラーを投げる
                    throw $e;
                }
            }
        }

        // 更新
        $user->update($validated);

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');
    }

    public function follow(User $user)
    {
        Auth::user()->followings()->attach($user->id);
        return back();
    }
    public function unfollow(User $user)
    {
        Auth::user()->followings()->detach($user->id);
        return back();
    }
}
