<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 会員一覧ページ
    public function index(Request $request)
    {
        // 検索キーワードの取得
        $keyword = $request->keyword;

        
        if ($request->user !== null) {
            $users = User::where('id', $request->user)->paginate(15);
        } elseif ($keyword !== null) {
            $users = User::where('name', 'like', "%{$keyword}%")->paginate(15);
        } else {
            $users = User::paginate(15);
        }

        $total = User::count();

        return view('admin.users.index', compact('users', 'keyword', 'total'));
    }

    // 会員詳細ページ
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

}
