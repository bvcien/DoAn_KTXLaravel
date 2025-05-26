<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;


class AdminBannerController extends Controller
{
    public function index() {
        $banners = Banner::all(); 
        return view('admin.Banner.index', compact('banners'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $banners = Banner::where('name', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.Banner.index', compact('banners'));
    }    

    public function delete($id) {
        $banner = Banner::findOrFail($id);
        $user = Auth::user();
    
        if ($user->competence == 0) {
            if ($banner->image && file_exists(public_path('Banner/' . $banner->image))) {
                unlink(public_path('Banner/' . $banner->image));
            }
        
            $banner->delete();
        
            return redirect()->route('admin.indexBanner')->with('success', 'Xóa hình chiếu thành công.');
        } else {
            return redirect()->route('admin.indexBanner')->with('error', 'Bạn không có quyền xóa.');
        }

    }
    
    
    public function create()
    {
        return view('admin.Banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Chỉ nhận ảnh
            'type'  => 'required|in:0,1,2',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'Banner' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Banner'), $imageName);
        } else {
            $imageName = null;
        }

        // Thêm mới Banner
        Banner::create([
            'name'  => $request->name,
            'image' => $imageName,
            'type'  => $request->type,
        ]);

        return redirect()->route('admin.createBanner')->with('success', 'Thêm Banner thành công.');
    }
}
