<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class)->middleware('auth');
Route::get('/search', [PostController::class, 'index'])->name('posts.search');

Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'delete']);
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/posts/{post}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth')->name('posts.favorite');
Route::post('/posts/{post}/visit', [VisitController::class, 'toggle'])->middleware('auth')->name('posts.visit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/mypage', [UserController::class, 'mypage'])->middleware('auth')->name('mypage');
Route::post('/users/{user}/follow', [UserController::class, 'follow'])->middleware('auth')->name('user.follow');
Route::delete('/users/{user}/unfollow', [UserController::class, 'unfollow'])->middleware('auth')->name('user.unfollow');
Route::get('/mypage/{id}/edit', [UserController::class, 'edit'])->name('mypage.edit');
Route::put('/mypage', [UserController::class, 'update'])->name('user.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
