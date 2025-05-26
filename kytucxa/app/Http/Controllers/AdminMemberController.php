<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Room;
use App\Models\User;
use App\Models\Pay;

class AdminMemberController extends Controller
{
    public function index() {
        $members = Member::with(['user', 'room'])->get(); 
        return view('admin.Member.index', compact('members'));
    }
    
    public function show(Member $member)
    {
        $bills = $member->user ? $member->user->bills()->with('details.pay')->get() : collect();

        $totalPaid = $bills->where('status', 1)->sum('totalPrice');
        $totalUnpaid = $bills->where('status', 0)->sum('totalPrice');

        return view('admin.Member.show', compact('member', 'bills', 'totalPaid', 'totalUnpaid'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $members = Member::where('name', 'LIKE', "%$search%")
                        ->orWhere('msv', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.Member.index', compact('members'));
    }    

    public function delete($id) {
        $member = Member::findOrFail($id);
    
        $member->delete();
    
        return redirect()->route('admin.indexMember')->with('success', 'Xóa thành viên thành công.');
    }
    
    
    public function create() {
        $users = User::where('role', 2)->get(); // Lấy danh sách người dùng có role = 2 (người dùng)
        $rooms = Room::all(); // Lấy tất cả phòng

        return view('admin.Member.create', compact('users', 'rooms'));
    }

    public function store(Request $request) {
        $request->validate([
            'idUser' => 'required|exists:users,id',
            'idRoom' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'msv' => 'required|string|max:50|unique:members,msv',
            'status' => 'required|in:0,1,2,3',
        ], [
            'idUser.required' => 'Vui lòng chọn người dùng.',
            'idUser.exists' => 'Người dùng không hợp lệ.',
            'idRoom.required' => 'Vui lòng chọn phòng KTX.',
            'idRoom.exists' => 'Phòng KTX không hợp lệ.',
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'msv.required' => 'Vui lòng nhập mã sinh viên.',
            'msv.unique' => 'Mã sinh viên đã tồn tại.',
            'status.required' => 'Vui lòng chọn trạng thái.',
        ]);

        Member::create([
            'idUser' => $request->idUser,
            'idRoom' => $request->idRoom,
            'name' => $request->name,
            'msv' => $request->msv,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.createMember')->with('success', 'Thêm thành viên thành công.');
    }
    
    public function edit($id) {
        $member = Member::findOrFail($id);
        $users = User::where('role', 2)->get();
        $rooms = Room::all(); 
    
        return view('admin.Member.edit', compact('member', 'users', 'rooms'));
    }

    public function update(Request $request, $id) {
        $member = Member::findOrFail($id);
    
        // Validate dữ liệu đầu vào
        $request->validate([
            'idUser' => 'required|exists:users,id',
            'idRoom' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'msv' => 'required|string|max:20',
            'status' => 'required|integer|in:0,1,2,3',
        ]);
    
        // Cập nhật dữ liệu
        $member->update([
            'idUser' => $request->idUser,
            'idRoom' => $request->idRoom,
            'name' => $request->name,
            'msv' => $request->msv,
            'status' => $request->status,
        ]);
    
        return redirect()->route('admin.indexMember')->with('success', 'Cập nhật thành viên thành công.');
    }
}
