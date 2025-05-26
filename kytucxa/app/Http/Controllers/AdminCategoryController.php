<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index() {
        $categories = Category::all(); 
        // Mới nhất từ trên xuống
        //$categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.Category.index', compact('categories'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $categories = Category::where('name', 'LIKE', "%$search%")
                        ->orWhere('address', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.Category.index', compact('categories'));
    }    

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            if ($category->image && file_exists(public_path('Category/' . $category->image))) {
                unlink(public_path('Category/' . $category->image));
            }

            $category->delete();

            return redirect()->route('admin.indexCategory')->with('success', 'Xóa danh mục thành công.');
        } else {
            
            return redirect()->route('admin.indexCategory')->with('error', 'Bạn không có quyền xóa danh mục.');
        }
    }

    public function create() {
        return view('admin.Category.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5096',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'Category' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Category'), $imageName);
        } else {
            $imageName = null;
        }

        Category::create([
            'name' => $request->name,
            'image' => $imageName, 
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.createCategory')->with('success', 'Thêm danh mục thành công.');
    }
    
    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.Category.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);
    
        // Nếu có ảnh mới, xóa ảnh cũ và upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($category->image && file_exists(public_path('Category/' . $category->image))) {
                unlink(public_path('Category/' . $category->image));
            }
    
            // Upload ảnh mới
            $image = $request->file('image');
            $imageName = 'Category' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Category'), $imageName);
        } else {
            $imageName = $category->image; // Giữ ảnh cũ nếu không upload ảnh mới
        }
    
        $category->update([
            'name' => $request->name,
            'image' => $imageName,
            'address' => $request->address,
            'description' => $request->description,
        ]);
    
        return redirect()->route('admin.indexCategory')->with('success', 'Cập nhật danh mục thành công.');
    }
}