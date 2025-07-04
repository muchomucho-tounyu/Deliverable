<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();
        if ($user->visits()->where('post_id', $post->id)->exists()) {
            $user->visits()->detach($post->id); // 行ったことある解除
        } else {
            $user->visits()->attach($post->id); // 行ったことない登録
        }
        return back();
    } //
}
