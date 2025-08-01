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

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post = Post::with(['comments.user', 'people', 'work', 'song', 'place', 'user'])->findOrFail($post->id);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

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
            'image_path' => $imageUrl,
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

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

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
            $post->image_path = $imageUrl;
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

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    }
}
