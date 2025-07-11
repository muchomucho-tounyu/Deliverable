<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class MapController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $googleMapsApiKey = config('services.google_maps.api_key');
        return view('map', compact('posts', 'googleMapsApiKey'));
    }
}
