<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'mv_url'];
    public function people()
    {
        return $this->belongsToMany(Person::class);
    }
    public function works()
    {
        return $this->belongsToMany(work::class);
    }
    public function places()
    {
        return $this->belongsToMany(Place::class);
    }
}
