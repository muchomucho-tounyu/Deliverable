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

        // デバッグ用：投稿数をログ出力
        \Log::info('投稿数: ' . $posts->count() . ', 総投稿数: ' . Post::count());

        return view('posts.index', compact('posts'));
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
            'person_name' => trim($request->input('person_name')) ?: null,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'work_name' => 'required_without:song_name|nullable|string|max:255',
            'song_name' => 'required_without:work_name|nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'place_name' => 'required|string|max:255',
            'body' => 'nullable|string',
            'visited' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $work = null;
        if (!empty($data['work_name'])) {
            $work = Work::firstOrCreate(['name' => $data['work_name']]);
        }
        $song = null;
        if (!empty($data['song_name'])) {
            $song = Song::firstOrCreate(['name' => $data['song_name']]);
        }
        $person = null;
        if (!empty($data['person_name'])) {
            $person = Person::firstOrCreate(['name' => $data['person_name']]);
        }
        $place = Place::firstOrCreate(['name' => $data['place_name']]);

        // Cloudinary画像アップロード
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'image' => $imageUrl,
            'body' => $data['body'],
            'visited' => $request->boolean('visited'),
        ]);

        // 多対多の関係を設定
        if ($place) {
            $post->places()->attach($place->id);
        }
        if ($work) {
            $post->works()->attach($work->id);
        }
        if ($song) {
            $post->songs()->attach($song->id);
        }
        if ($person) {
            $post->people()->attach($person->id);
        }

        return redirect()->route('posts.index')->with('success', '投稿が完了しました！');
    }



    //


    /**
     * Display the specified resource.
     */



    public function show($id)
    {
        $post = Post::with(['comments.user', 'people', 'work', 'song', 'place', 'user'])->findOrFail($id);
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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'work_name' => 'nullable|string|max:255',
            'song_name' => 'nullable|string|max:255',
            'place_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'body' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $work = null;
        if (!empty($data['work_name'])) {
            $work = Work::firstOrCreate(['name' => $data['work_name']]);
        }
        $song = null;
        if (!empty($data['song_name'])) {
            $song = Song::firstOrCreate(['name' => $data['song_name']]);
        }
        $place = Place::firstOrCreate(['name' => $data['place_name']]);
        $place->address = $data['address'];
        $place->save();

        // Cloudinary画像アップロード（あれば）
        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $post->image = $imageUrl;
        }

        $post->title = $data['title'];
        $post->body = $data['body'] ?? null;
        $post->save();

        // 多対多の関係を更新
        $post->places()->sync([$place->id]);
        $post->works()->sync($work ? [$work->id] : []);
        $post->songs()->sync($song ? [$song->id] : []);

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
