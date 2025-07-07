<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        if ($user) {
            $user->load['posts,favorites,favorites,user,visits'];
        }
        return view('user.mypage', compact('user')); //
    }

    public function follow(User $user)
    {
        Auth::user()->followings()->attach($user->id);
        return back();
    }
    public function unfollow(User $user)
    {
        Auth::user()->followings()->detach($user->id);
        return back();
    }
}
