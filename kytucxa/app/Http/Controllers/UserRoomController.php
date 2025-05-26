<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Room;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class UserRoomController extends Controller
{
    public function index() {
        $categories = Category::all();
        $user = Auth::user();
        $member = Member::where('idUser', $user->id)->first();
    
        return view('user.RegisterKTX.index', compact('categories', 'user', 'member'));
    }

    public function getRooms($idCategory) {
        $rooms = Room::where('idCategory', $idCategory)->get();
        return response()->json($rooms);
    }

    public function getRoomDetails($id) {
        $room = Room::with('members')->findOrFail($id);
        return response()->json($room);
    }

    public function register(Request $request) {
        $request->validate([
            'idRoom' => 'required|exists:rooms,id',
        ]);
    
        $user = Auth::user();
        $room = Room::findOrFail($request->idRoom);
    
        // Kiểm tra giới tính của người dùng và loại phòng
        if (($user->sex == 0 && $room->type == 'nữ') || ($user->sex == 1 && $room->type == 'nam')) {
            return redirect()->route('user.indexDangKyKTX')->with('error', 'Phòng KTX này không phù hợp với giới tính của bạn.');
        }
    
        // Kiểm tra xem người dùng đã đăng ký phòng chưa
        $existingMember = Member::where('idUser', $user->id)->first();
    
        if ($existingMember) {
            return redirect()->route('user.indexDangKyKTX')->with('error', 'Bạn đã đăng ký phòng ở KTX!');
        }
    
        // Nếu chưa đăng ký và phòng phù hợp giới tính thì tạo mới
        Member::create([
            'idUser' => $user->id,
            'idRoom' => $request->idRoom,
            'name' => $user->name,
            'msv' => $user->msv,
            'status' => 2,
        ]);
    
        return redirect()->route('user.indexDangKyKTX')->with('success', 'Đăng ký thành công!');
    }
    
    public function requestCancelRegistration() {
        $user = Auth::user();
        $member = Member::where('idUser', $user->id)->first();
    
        if ($member) {
            if ($member->status == 0) {
                $member->status = 3; // Chuyển sang trạng thái chờ duyệt hủy
                $member->save();
                return redirect()->route('user.indexDangKyKTX')->with('success', 'Yêu cầu hủy đăng ký KTX thành công. Vui lòng chờ quản trị viên duyệt.');
            } elseif ($member->status == 2) {
                $member->delete();
                return redirect()->route('user.indexDangKyKTX')->with('success', 'Hủy yêu cầu đăng ký thành công.');
            } else {
                return redirect()->route('user.indexDangKyKTX')->with('error', 'Không thể thực hiện thao tác hủy vào lúc này.');
            }
        } else {
            return redirect()->route('user.indexDangKyKTX')->with('error', 'Bạn chưa đăng ký phòng ở KTX.');
        }
    }
}
