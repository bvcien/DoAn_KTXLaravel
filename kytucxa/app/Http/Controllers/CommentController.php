<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'idNews' => 'required|exists:news,id',
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'idUser' => Auth::id(),
            'idNews' => $request->idNews,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Bình luận đã được gửi!');
    }
}
