<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    public function getPaginateByLimit(int $limit_count = 5)
    {
        return $this::with('user')->orderBy('updated_at', 'desc')->paginate($limit_count);
    }

    protected $fillable = [
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


    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class);
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
}
