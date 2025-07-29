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
                'posts' => function ($query) {
                    $query->orderBy('updated_at', 'desc');
                },
                'favorites' => function ($query) {
                    $query->orderBy('updated_at', 'desc');
                },
                'favorites.user',
                'visits' => function ($query) {
                    $query->orderBy('updated_at', 'desc');
                },
                'followings',
                'followers',
            ]);

            // デバッグ用：リレーションデータをログ出力
            \Log::info('Mypage データ確認', [
                'user_id' => $user->id,
                'posts_count' => $user->posts->count(),
                'favorites_count' => $user->favorites->count(),
                'visits_count' => $user->visits->count(),
                'posts_with_images' => $user->posts->whereNotNull('image_path')->count(),
                'favorites_with_images' => $user->favorites->whereNotNull('image_path')->count(),
                'visits_with_images' => $user->visits->whereNotNull('image_path')->count(),
            ]);
        }
        return view('user.mypage', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        \Log::info('=== UPDATE METHOD CALLED ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('All request data: ', $request->all());
        \Log::info('Files: ', $request->allFiles());
        \Log::info('Has file image: ' . ($request->hasFile('image') ? 'YES' : 'NO'));
        \Log::info('File input exists: ' . ($request->file('image') ? 'YES' : 'NO'));
        if ($request->file('image')) {
            \Log::info('File details: ', [
                'name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize(),
                'mime' => $request->file('image')->getMimeType(),
                'valid' => $request->file('image')->isValid()
            ]);
        }

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
            'bio' => ['nullable', 'string', 'max:1000'],
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

        // Cloudinaryに画像をアップロード
        if ($request->hasFile('image')) {
            try {
                $result = Cloudinary::upload($request->file('image')->getRealPath());
                $validated['image'] = $result->getSecurePath();
                \Log::info('Cloudinary画像URL: ' . $validated['image']);
            } catch (\Exception $e) {
                \Log::error('Cloudinaryアップロードエラー: ' . $e->getMessage());
                return back()->withErrors(['image' => '画像のアップロードに失敗しました']);
            }
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
