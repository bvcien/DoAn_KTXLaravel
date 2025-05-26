<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pay;
use App\Models\Member;
use App\Models\Room;

class AdminPayController extends Controller
{
    public function index() {
        $pays = Pay::all(); 
        return view('admin.Pay.index', compact('pays'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $pays = Pay::whereHas('member', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    })
                    ->get();
    
        return view('admin.Pay.index', compact('pays'));
    }
      

    public function delete($id) {
        $pay = Pay::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            $pay->delete();
    
            return redirect()->route('admin.indexPay')->with('success', 'Xóa thanh toán thành công.');
        } else {
            return redirect()->route('admin.indexPay')->with('error', 'Bạn không có quyền xóa.');
        }
    }
    
    
    // Hiển thị form thêm theo phòng
    public function createByRoom() {
        $rooms = Room::all();
        return view('admin.Pay.create_room', compact('rooms'));
    }
        
    // Xử lý lưu theo phòng
    public function storeByRoom(Request $request) {
        $request->validate([
            'idRoom' => 'required|exists:rooms,id',
            'time_at' => 'required|date',
            'time_out' => 'required|date|after:time_at',
            'note' => 'nullable|string',
        ]);
        
        $room = Room::findOrFail($request->idRoom);
        $members = Member::where('idRoom', $room->id)->get();
        
        foreach ($members as $member) {
            Pay::create([
                'idMember' => $member->id,
                'price' => $room->price,
                'time_at' => $request->time_at,
                'time_out' => $request->time_out,
                'note' => $request->note,
                'status' => 0,
            ]);
        }
        
        return redirect()->route('admin.createPayRoom')->with('success', 'Thêm thanh toán theo phòng thành công.');
    }
    
    // Hiển thị form thêm theo thành viên
    public function createByMember() {
        $members = Member::with('room')->get();
        return view('admin.Pay.create_member', compact('members'));
    }
    
    // Xử lý lưu theo thành viên
    public function storeByMember(Request $request) {
        $request->validate([
            'idMember' => 'required|array',
            'idMember.*' => 'exists:members,id',
            'time_at' => 'required|date',
            'time_out' => 'required|date|after:time_at',
            'note' => 'nullable|string',
        ]);
    
        foreach ($request->idMember as $idMember) {
            $member = Member::findOrFail($idMember);
            Pay::create([
                'idMember' => $idMember,
                'price' => $member->room->price,
                'time_at' => $request->time_at,
                'time_out' => $request->time_out,
                'note' => $request->note,
                'status' => 0,
            ]);
        }
    
        return redirect()->route('admin.createPayMember')->with('success', 'Thêm thanh toán theo thành viên thành công.');
    }
    
    public function edit($id) {
        $pay = Pay::with('member')->findOrFail($id);
        return view('admin.Pay.edit', compact('pay'));
    }
    
    public function update(Request $request, $id) {
        $pay = Pay::findOrFail($id);
    
        $request->validate([
            'time_at' => 'required|date',
            'time_out' => 'required|date|after:time_at',
            'status' => 'required|integer',
            'note' => 'nullable|string'
        ]);
    
        $pay->update([
            'time_at' => $request->time_at,
            'time_out' => $request->time_out,
            'note' => $request->note,
            'status' => $request->status
        ]);
    
        return redirect()->route('admin.indexPay')->with('success', 'Cập nhật khoản thanh toán thành công.');
    }    
}
