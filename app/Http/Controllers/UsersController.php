<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // 自分以外のユーザーを取得
        $users = User::where('id', '!=', Auth::id())
                    ->when($keyword, function ($query, $keyword) {
                        return $query->where('username', 'like', "%{$keyword}%");
                    })
                    ->get();

        return view('users.search', compact('users', 'keyword'));

    }
}
