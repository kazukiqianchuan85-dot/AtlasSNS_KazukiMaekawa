<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    // 自分のプロフィール（編集用）
    public function profile()
    {
        $user = Auth::user();
        $posts = $user->posts()->latest()->get();

        return view('profiles.profile', [
        'user' => $user,
        'posts' => $posts,
        'isOwnProfile' => true,   // 自分のプロフィールであることを明示
        ]);
    }

    // 他ユーザーのプロフィール（閲覧用）
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->latest()->get();

        return view('profiles.profile', [
        'user' => $user,
        'posts' => $posts,
        'isOwnProfile' => false,  // 他人のプロフィール
        ]);
    }

    // プロフィール更新
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'email' => 'required|string|email|min:5|max:40|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'bio' => 'nullable|string|max:150',
            'image' => 'nullable|mimes:jpg,png,bmp,gif,svg|max:2048',
        ]);

        // 更新処理
        $user->username = $request->username;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $user->icon_image = $imageName;
        }

        $user->save();

        return redirect()->route('posts.index')->with('status', 'プロフィールを更新しました');
    }
}
