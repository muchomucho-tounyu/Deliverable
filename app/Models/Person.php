<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function works()
    {
        return $this->belongsToMany(Work::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
