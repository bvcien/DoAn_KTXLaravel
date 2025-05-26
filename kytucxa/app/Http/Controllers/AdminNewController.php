<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;

class AdminNewController extends Controller
{
    public function index() {
        // $news = News::all(); 
        $news = News::orderBy('created_at', 'desc')->get();
        return view('admin.New.index', compact('news'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $news = News::where('title', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.New.index', compact('news'));
    }    

    public function delete($id) {
        $new = News::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            if ($new->image && file_exists(public_path('New/' . $new->image))) {
                unlink(public_path('New/' . $new->image));
            }
        
            $new->delete();
        
            return redirect()->route('admin.indexNew')->with('success', 'Xóa bài viết, tin tức thành công.');
        } else {
            return redirect()->route('admin.indexNew')->with('error', 'Bạn không có quyền xóa.');
        }
    }
    
    
    public function create() {
        return view('admin.New.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'New' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('New'), $imageName);
        }

        News::create([
            'idUser' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.createNew')->with('success', 'Thêm bài viết, tin tức thành công.');
    }
    
    public function edit($id) {
        $new = News::findOrFail($id);
        return view('admin.New.edit', compact('new'));
    }

    public function update(Request $request, $id) {
        $new = News::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Xử lý ảnh
        $imageName = $new->image; // Mặc định giữ ảnh cũ
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($new->image && file_exists(public_path('New/' . $new->image))) {
                unlink(public_path('New/' . $new->image));
            }

            // Upload ảnh mới
            $image = $request->file('image');
            $imageName = 'New' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('New'), $imageName);
        }

        // Cập nhật dữ liệu
        $new->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.indexNew')->with('success', 'Cập nhật bài viết, tin tức thành công.');
    }
}
