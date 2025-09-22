<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

        return view('profiles.profile', compact('user', 'posts'));
    }

    // 他ユーザーのプロフィール（閲覧用）
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->latest()->get();

        return view('profiles.profile', compact('user', 'posts'));
    }
}
