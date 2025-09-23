<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    //フォローリストページ
    public function followList(){
        $user = Auth::user();

        // 自分がフォローしているユーザー
        $followings = $user->followings()->get();

        // フォローしているユーザーの投稿を新しい順で取得
        $posts = Post::whereIn('user_id', $followings->pluck('id'))
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('follows.followList', compact('followings', 'posts'));
    }

    public function followerList(){
        $user = auth()->user();

        // 自分をフォローしているユーザー（フォロワー）を取得
        $followers = $user->followers;

        // フォロワーの投稿を新しい順で取得
        $posts = Post::whereIn('user_id', $followers->pluck('id'))
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('follows.followerList', compact('followers', 'posts'));

    }

    // フォローする
    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);
        Auth::user()->followings()->attach($user->id);

        return redirect($request->input('redirect_to', route('profile.show', $id))); // その場で更新
    }

    // フォロー解除
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        Auth::user()->followings()->detach($user->id);

        return redirect($request->input('redirect_to', route('profile.show', $id))); // その場で更新
    }
}
