<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    //
    public function followList(){
        return view('follows.followList');
    }
    public function followerList(){
        return view('follows.followerList');
    }

    // フォローする
    public function store($id)
    {
        $user = User::findOrFail($id);
        Auth::user()->followings()->attach($user->id);

        return redirect()->route('user.search')->withInput(); // 検索画面に戻る
    }

    // フォロー解除
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Auth::user()->followings()->detach($user->id);

        return redirect()->route('user.search')->withInput(); // 検索画面に戻る
    }
}
