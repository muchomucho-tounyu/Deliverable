<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary as CloudinarySDK;

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
                'visits',
                'followings',
                'followers',
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

        // プロフィール画像アップロード（画像が選択された場合のみ）
        \Log::info('画像アップロード処理開始', [
            'has_file' => $request->hasFile('image'),
            'file_valid' => $request->hasFile('image') ? $request->file('image')->isValid() : false,
            'file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 0,
            'all_files' => $request->allFiles(),
            'request_all' => $request->all()
        ]);

        // デバッグ用：リクエストの詳細をログ出力
        \Log::info('リクエスト詳細', [
            'method' => $request->method(),
            'url' => $request->url(),
            'all_input' => $request->all(),
            'files' => $request->allFiles()
        ]);

        // 強制的にテスト用画像URLを設定
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            \Log::info('ファイル情報', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_path' => $file->getRealPath(),
                'file_valid' => $file->isValid()
            ]);

            try {
                // Cloudinary SDKを直接使用
                $cloudinary = new CloudinarySDK([
                    'cloud' => [
                        'cloud_name' => 'ddmyych6n',
                        'api_key' => '441491558761823',
                        'api_secret' => 's3PK6sJIr700UXhcCvQ5qBVFNJo',
                    ]
                ]);

                $result = $cloudinary->uploadApi()->upload($file->getRealPath());
                $validated['image'] = $result['secure_url'];
                \Log::info('Cloudinary画像URL: ' . $validated['image']);
            } catch (\Exception $e) {
                \Log::error('Cloudinaryアップロードエラー: ' . $e->getMessage());
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()]);
            }
        } else {
            \Log::info('画像が選択されていません');
        }

        // 更新
        $user->update($validated);

        // 更新後のユーザー情報をログ出力
        \Log::info('ユーザー更新完了', [
            'user_id' => $user->id,
            'image_url' => $user->fresh()->image,
            'all_data' => $user->fresh()->toArray()
        ]);

        // デバッグ用: 画像が選択されていない場合の処理
        if (!$request->hasFile('image')) {
            \Log::info('画像が選択されていません');
        }

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
