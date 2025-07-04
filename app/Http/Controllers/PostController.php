<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['places', 'work', 'song'])->orderBy('updated_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts')); //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create'); //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index')->with('success', '投稿しました');
    }
    //


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $post->load(['place', 'work', 'song']);
        return view('posts.show', compact('post')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('success', '投稿が更新されました。');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    } //

}
