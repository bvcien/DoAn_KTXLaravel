<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AdminAccountController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 0)->get();
        $employees = User::where('role', 1)->get();
        $users = User::where('role', 2)->get();

        return view('admin.Account.index', compact('admins', 'employees', 'users'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
    
        $users = User::where('msv', 'LIKE', "%$search%")
                        ->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->get();
    
        return view('admin.Account.index', compact('users'));
    }   

    public function create()
    {
        return view('admin.Account.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'msv' => 'required|string|max:20|unique:users,msv',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'tel' => 'nullable|string|max:15',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1',
            'role' => 'required|in:0,1,2',
            'cccd' => 'required|string|max:20',
            'sex' => 'required|in:0,1,2',
            'competence' => 'required|in:0,1',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'Avatar' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Avatar'), $imageName);
        } else {
            $imageName = null;
        }
    
        User::create([
            'msv' => $request->msv,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'date' => $request->date,
            'address' => $request->address,
            'image' => $imageName,
            'status' => $request->status,
            'role' => $request->role,
            'code' => null,
            'cccd' => $request->cccd,
            'sex' => $request->sex,
            'competence' => $request->competence,
        ]);
    
        return redirect()->route('admin.indexAccount')->with('success', 'Thêm tài khoản thành công.');
    }
    

    public function edit($id)
    {
        $loggedInUser = Auth::user();
        $user = User::findOrFail($id);

        // Kiểm tra quyền sửa
        if ($loggedInUser->role == 1 && $loggedInUser->id != $user->id && $user->role != 2) {
            return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền sửa tài khoản này.');
        }

        if ($loggedInUser->role == 0 && $loggedInUser->id != $user->id && $user->role == 0) {
            return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền sửa tài khoản Quản trị khác.');
        }
        
        return view('admin.Account.edit', compact('user', 'loggedInUser'));
    }
    
    public function update(Request $request, $id)
    {
        $loggedInUser = Auth::user();
        $userToUpdate = User::findOrFail($id);

        // Kiểm tra quyền sửa trước khi cập nhật
        if ($loggedInUser->role == 1 && $userToUpdate->role != 2) {
            return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền cập nhật tài khoản này.');
        }

        if ($loggedInUser->role == 0 && $loggedInUser->id != $userToUpdate->id && $userToUpdate->role == 0) {
            return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền cập nhật tài khoản Quản trị khác.');
        }

        $request->validate([
            'msv' => 'required|string|max:20|unique:users,msv,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'tel' => 'nullable|string|max:15',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1',
            'role' => 'required|in:0,1,2',
            'cccd' => 'required|string|max:20',
            'sex' => 'required|in:0,1,2',
            'competence' => 'required|in:0,1',
        ]);

        // Kiểm tra và ngăn chặn việc thay đổi role trái phép
        if ($loggedInUser->role == 1 && $userToUpdate->role == 2 && $request->role != 2) {
            return redirect()->back()->with('error', 'Nhân viên chỉ được phép giữ nguyên hoặc thay đổi các thuộc tính khác của tài khoản Người dùng.');
        }

        if ($loggedInUser->role == 0 && $loggedInUser->id != $userToUpdate->id && $userToUpdate->role == 0 && $request->role != 0) {
            return redirect()->back()->with('error', 'Bạn không có quyền thay đổi quyền hạn của tài khoản Quản trị khác.');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'Avatar' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Avatar'), $imageName);
            $userToUpdate->image = $imageName;
        }

        $userToUpdate->msv = $request->msv;
        $userToUpdate->name = $request->name;
        $userToUpdate->email = $request->email;
        $userToUpdate->tel = $request->tel;
        $userToUpdate->date = $request->date;
        $userToUpdate->address = $request->address;
        $userToUpdate->status = $request->status;
        $userToUpdate->role = $request->role;
        $userToUpdate->cccd = $request->cccd;
        $userToUpdate->sex = $request->sex;
        $userToUpdate->competence = $request->competence;

        if (!empty($request->password)) {
            $userToUpdate->password = Hash::make($request->password);
        }

        $userToUpdate->save();

        return redirect()->route('admin.indexAccount')->with('success', 'Cập nhật tài khoản thành công.');
    }


    public function delete($id)
    {
        $userToDelete = User::findOrFail($id);
        $currentUser = Auth::user();

        if ($currentUser->competence == 0) {
            // Kiểm tra nếu người dùng đang xóa chính mình
            if ($currentUser->id == $userToDelete->id) {
                return redirect()->route('admin.indexAccount')->with('error', 'Bạn không thể tự xóa tài khoản của mình.');
            }

            // Kiểm tra phân quyền
            if ($currentUser->role == 0) {
                // Admin (role 0) có thể xóa nhân viên (role 1) và người dùng (role 2)
            } elseif ($currentUser->role == 1) {
                // Nhân viên (role 1) chỉ có thể xóa người dùng (role 2)
                if ($userToDelete->role == 0) {
                    return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền xóa tài khoản quản trị.');
                }
            } else {
                // Người dùng (role 2) không có quyền xóa bất kỳ tài khoản nào
                return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền xóa tài khoản.');
            }

            // Xóa ảnh nếu tồn tại
            if ($userToDelete->image && file_exists(public_path('Avatar/' . $userToDelete->image))) {
                unlink(public_path('Avatar/' . $userToDelete->image));
            }

            $userToDelete->delete();

            return redirect()->route('admin.indexAccount')->with('success', 'Xóa tài khoản thành công.');
        } else {
            return redirect()->route('admin.indexAccount')->with('error', 'Bạn không có quyền xóa.');
        }

       
    }
}
