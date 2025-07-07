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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Post::with(['user', 'work', 'song', 'place', 'people']);
        if (!empty($keyword)) {
            $query->where('title', 'like', "%{$keyword}%")
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('work', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('song', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('place', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('people', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
        }

        $posts = $query->orderBy('updated_at', 'desc')->paginate(10);


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
        $request->merge([
            'work_name' => trim($request->input('work_name')) ?: null,
            'song_name' => trim($request->input('song_name')) ?: null,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:255',

            'work_name' => 'required_without:song_name|nullable|string|max:255',
            'song_name' => 'required_without:work_name|nullable|string|max:255',

            'place_name' => 'required|string|max:255',
            'body' => 'nullable|string',
            'visited' => 'nullable|boolean',
            'image_path' => 'nullable|image|max:2048',
        ]);

        // workの作成 or null
        $work = null;
        if (!empty($data['work_name'])) {
            $work = Work::firstOrCreate(['name' => $data['work_name']]);
        }

        // songの作成 or null
        $song = null;
        if (!empty($data['song_name'])) {
            $song = Song::firstOrCreate(['name' => $data['song_name']]);
        }

        // placeの作成
        $place = Place::firstOrCreate(['name' => $data['place_name']]);

        // 画像保存
        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
        }

        // 投稿作成
        Post::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'work_id' => $work?->id,
            'song_id' => $song?->id,
            'place_id' => $place->id,
            'image_path' => $imagePath,
            'body' => $data['body'],
            'visited' => $request->boolean('visited'),
        ]);

        return redirect()->route('posts.index')->with('success', '投稿が完了しました！');
    }



    //


    /**
     * Display the specified resource.
     */



    public function show($id)
    {
        $post = Post::with(['people', 'work', 'song', 'place', 'user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }
    //


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
        // バリデーション
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'work_name' => 'nullable|string|max:255',
            'song_name' => 'nullable|string|max:255',
            'place_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'body' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',

        ]);

        // work更新 or 作成
        $work = null;
        if (!empty($data['work_name'])) {
            $work = Work::firstOrCreate(['name' => $data['work_name']]);
        }

        // song更新 or 作成
        $song = null;
        if (!empty($data['song_name'])) {
            $song = Song::firstOrCreate(['name' => $data['song_name']]);
        }

        // place更新 or 作成
        $place = Place::firstOrCreate(['name' => $data['place_name']]);
        // addressはPlaceモデルに保存するならここで更新してね
        $place->address = $data['address'];
        $place->save();

        // 画像アップロード（あれば）
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $post->image_path = $imagePath;
        }

        // Postモデル更新
        $post->title = $data['title'];
        $post->work_id = $work?->id;
        $post->song_id = $song?->id;
        $post->place_id = $place->id;
        $post->body = $data['body'] ?? null;
        $post->save();

        return redirect()->route('posts.show', $post)->with('success', '投稿が更新されました。');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    } //



    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

        // 画像URLをDBに保存
        return response()->json(['url' => $uploadedFileUrl]);
    }
}
