<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;

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



require __DIR__ . '/auth.php';

// ログイン済の時のみアクセス可能
Route::middleware('auth')->group(function () {
    // トップページ
    Route::get('top', [PostsController::class, 'index']);

    // プロフィール編集ページ
    Route::get('profile', [ProfileController::class, 'profile']);

    // ユーザー検索ページ
    Route::get('/search', [UsersController::class, 'index'])->name('user.search');

    // フォロー
    Route::post('/users/{id}/follow', [FollowController::class, 'store'])->name('follow');

    // フォロー解除
    Route::post('/users/{id}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');

    // フォローリストページ
    Route::get('follow-list', [PostsController::class, 'index']);

    // フォロワーリストページ
    Route::get('follower-list', [PostsController::class, 'index']);

    //ポストページ
    Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    //ポスト編集
    Route::post('/posts/{id}/update', [PostsController::class, 'update'])->name('posts.update');
    Route::put('/posts/{id}', [App\Http\Controllers\PostsController::class, 'update'])->name('posts.update');
    //ポスト削除
    Route::delete('/posts/{id}', [App\Http\Controllers\PostsController::class, 'destroy'])->name('posts.destroy');

});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login'); // ログインページへ
});
