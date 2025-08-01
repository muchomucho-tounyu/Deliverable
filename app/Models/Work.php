<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'overview', 'trailer_url', 'official_site'];
    public function people()
    {
        return $this->belongsToMany(Person::class);
    }
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
    public function places()
    {
        return $this->belongsToMany(Place::class);
    }
}
