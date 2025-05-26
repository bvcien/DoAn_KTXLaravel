<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Category;

class AdminRoomController extends Controller
{
    public function index() {
        $rooms = Room::with('category')->get();
        return view('admin.Room.index', compact('rooms'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $rooms = Room::where('name', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('status', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.Room.index', compact('rooms'));
    }    

    public function delete($id) {
        $room = Room::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            // Xóa ảnh nếu tồn tại
            if ($room->image && file_exists(public_path('Room/' . $room->image))) {
                unlink(public_path('Room/' . $room->image));
            }
        
            // Xóa danh mục
            $room->delete();
        
            return redirect()->route('admin.indexRoom')->with('success', 'Xóa phòng thành công.');
        } else {
            return redirect()->route('admin.indexRoom')->with('error', 'Bạn không có quyền xóa.');
        }
    }
    
    
    public function create() {
        $categories = Category::all();
        return view('admin.Room.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idCategory' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:rooms,name',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:0,1,2',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'type' => 'nullable|string|in:nam,nữ', // Thêm validation cho type
        ]);

        // Xử lý upload hình ảnh
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'Room' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Room'), $imageName);
        }

        // Lưu thông tin vào database
        Room::create([
            'idCategory' => $request->idCategory,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imageName,
            'type' => $request->type, // Lưu giá trị type
        ]);

        return redirect()->route('admin.createRoom')->with('success', 'Thêm phòng thành công.');
    }
    
    public function edit($id) {
        $room = Room::findOrFail($id);
        $categories = Category::all();
        return view('admin.Room.edit', compact('room', 'categories'));
    }

    public function update(Request $request, $id) {
        $room = Room::findOrFail($id);
    
        $request->validate([
            'idCategory' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:0,1,2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'nullable|string|in:nam,nữ', // Thêm validation cho type
        ]);
    
        // Nếu có ảnh mới, xóa ảnh cũ và upload ảnh mới
        $imageName = $room->image; // Giá trị mặc định là ảnh cũ
        if ($request->hasFile('image')) {
            if ($room->image && file_exists(public_path('Room/' . $room->image))) {
                unlink(public_path('Room/' . $room->image));
            }
            $image = $request->file('image');
            $imageName = 'Room' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Room'), $imageName);
        }
    
        $room->update([
            'idCategory' => $request->idCategory,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imageName,
            'type' => $request->type, // Cập nhật giá trị type
        ]);
    
        return redirect()->route('admin.indexRoom')->with('success', 'Cập nhật phòng KTX thành công.');
    }
}
