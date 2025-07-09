<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ]);
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);
        return redirect()->back()->with('message', 'コメントを投稿しました'); //
    }
}
