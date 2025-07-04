<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class FavoriteController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();
        if ($user->favorites()->where('post_id', $post->id)->exists()) {
            $user->favorites()->detach($post->id); // お気に入り解除
        } else {
            $user->favorites()->attach($post->id); // お気に入り登録
        }
        return back();
    } //
}
