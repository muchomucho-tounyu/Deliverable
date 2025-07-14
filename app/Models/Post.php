<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getPaginateByLimit(int $limit_count = 5)
    {
        return $this::with('user')->orderBy('updated_at', 'desc')->paginate($limit_count);
    }

    protected $fillable = [
        'title',
        'work_id',
        'work_name',
        'song_id',
        'song_name',
        'person_id',
        'location',
        'image',
        'body',
        'user_id',



    ];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'person_post', 'post_id', 'person_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'place_post', 'post_id', 'place_id');
    }

    public function works()
    {
        return $this->belongsToMany(Work::class, 'post_work', 'post_id', 'work_id');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'post_song', 'post_id', 'song_id');
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function visitedByUsers()
    {
        return $this->belongsToMany(User::class, 'visits')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
