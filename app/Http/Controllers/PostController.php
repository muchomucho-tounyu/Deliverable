<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Place;
use App\Models\Person;
use App\Models\Song;
use App\Models\Work;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
<<<<<<< Updated upstream

        $query = Post::with(['user', 'work', 'song', 'place', 'people']);

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('posts.title', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($userQuery) use ($keyword) {
                        $userQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('works', function ($workQuery) use ($keyword) {
                        $workQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('songs', function ($songQuery) use ($keyword) {
                        $songQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('places', function ($placeQuery) use ($keyword) {
                        $placeQuery->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('people', function ($personQuery) use ($keyword) {
                        $personQuery->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $posts = $query->orderBy('updated_at', 'desc')->paginate(10);

=======
        
        $query = Post::with(['user', 'work', 'song', 'place', 'people']);
        
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('work', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('song', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('place', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('people', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', "%{$keyword}%");
                    });
            });
        }
        
        $posts = $query->orderBy('updated_at', 'desc')->paginate(10);
        
>>>>>>> Stashed changes
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post($validated);
        $post->user_id = auth()->id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image_path = $imagePath;
        }
        
        $post->save();
        
        return redirect()->route('posts.show', $post)->with('success', '投稿を作成しました。');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $validated['image_path'] = $imagePath;
        }
        
        $post->update($validated);
        
        return redirect()->route('posts.show', $post)->with('success', '投稿を更新しました。');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
