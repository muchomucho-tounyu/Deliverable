<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $uploadedUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $user->image = $uploadedUrl;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * 指定IDのユーザープロフィールを表示
     */
    public function show($id)
    {
        $user = \App\Models\User::with(['posts', 'followings', 'followers'])->find($id);
        if (!$user) {
            return redirect('/')->with('error', 'ユーザーが見つかりませんでした');
        }
        return view('profile.show', compact('user'));
    }

    /**
     * 指定IDのユーザーがフォローしているユーザー一覧
     */
    public function followings($id)
    {
        $user = \App\Models\User::with('followings')->findOrFail($id);
        $followings = $user->followings;
        return view('profile.followings', compact('user', 'followings'));
    }

    /**
     * 指定IDのユーザーをフォローしているユーザー一覧
     */
    public function followers($id)
    {
        $user = \App\Models\User::with('followers')->findOrFail($id);
        $followers = $user->followers;
        return view('profile.followers', compact('user', 'followers'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
