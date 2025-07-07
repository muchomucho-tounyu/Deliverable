<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

        // プロフィール画像アップロード
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($user->image) {
                Storage::delete($user->image);
            }

            $path = $request->file('image')->store('profile_images');
            $validated['image'] = $path;
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
