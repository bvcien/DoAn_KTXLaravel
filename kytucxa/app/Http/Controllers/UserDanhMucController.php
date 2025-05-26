<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class UserDanhMucController extends Controller
{
    public function index($id) {
        $category = Category::with(['rooms', 'rooms.members'])->findOrFail($id);
        return view('user.DanhMuc.index', compact('category'));
    }
}
