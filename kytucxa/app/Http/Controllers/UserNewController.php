<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\NewsLike;

class UserNewController extends Controller
{
    public function index($id) {
        $news = News::with('user', 'likes')->findOrFail($id);
    
        // Lấy các bài viết khác của cùng tác giả (trừ bài đang xem)
        $relatedNews = News::where('idUser', $news->idUser)
            ->where('id', '!=', $id)
            ->latest()
            ->take(5) // Giới hạn hiển thị 5 bài
            ->get();
    
        return view('user.TinTuc.index', compact('news', 'relatedNews'));
    }
    
    public function like($id) {
        return $this->toggleLikeDislike($id, 0);
    }

    public function dislike($id) {
        return $this->toggleLikeDislike($id, 1);
    }

    private function toggleLikeDislike($id, $status) {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thực hiện thao tác này!'], 401);
        }

        $like = NewsLike::where('idUser', $user->id)->where('idNew', $id)->first();

        if ($like) {
            if ($like->status == $status) {
                $like->status = 2; // Hủy like/dislike
            } else {
                $like->status = $status;
            }
            $like->save();
        } else {
            NewsLike::create([
                'idUser' => $user->id,
                'idNew' => $id,
                'status' => $status
            ]);
        }

        $news = News::with('likes')->findOrFail($id);
        return response()->json([
            'likes' => $news->likes->where('status', 0)->count(),
            'dislikes' => $news->likes->where('status', 1)->count(),
            'userStatus' => $like ? $like->status : 2
        ]);
    }
}
