<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostsController extends Controller
{
    // 投稿一覧
    public function index()
    {
        $user = auth()->user();

        // 自分とフォロー中ユーザーのIDをまとめる
        $followIds = $user->followings()->pluck('followed_id')->toArray();
        $visibleUserIds = array_merge([$user->id], $followIds);

        // 投稿を新しい順で取得（ユーザー情報も一緒に）
        $posts = Post::with('user')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    // 投稿保存処理
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'post' => 'required|string|min:1|max:150',
        ]);

        // 投稿を保存
        Post::create([
            'user_id' => Auth::id(),
            'post'    => $request->post,
        ]);

        return redirect()->back()->with('success', '投稿が完了しました！');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'post' => 'required|string|min:1|max:150',
        ]);

        $post = Post::findOrFail($id);

        // 自分の投稿のみ編集できる
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', '自分の投稿のみ編集できます。');
        }

        $post->update([
            'post' => $request->post,
        ]);

        return redirect()->route('posts.index')->with('success', '投稿を編集しました！');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 自分の投稿のみ削除
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
