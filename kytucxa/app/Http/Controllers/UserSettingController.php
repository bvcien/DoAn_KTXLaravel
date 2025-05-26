<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class UserSettingController extends Controller
{
    public function index()
    {
        return view('user.Setting.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|numeric|digits_between:10,11',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'cccd' => 'required|string|max:20',
            'sex' => 'required|in:0,1,2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'old_password' => 'nullable|string|min:8',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Cập nhật thông tin cá nhân
        $user->name = $request->name;
        $user->tel = $request->tel;
        $user->address = $request->address;
        $user->date = $request->date;
        $user->cccd = $request->cccd;
        $user->sex = $request->sex;

        // Cập nhật ảnh đại diện
        if ($request->hasFile('image')) {
            if ($user->image && File::exists(public_path('Avatar/' . $user->image))) {
                File::delete(public_path('Avatar/' . $user->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Avatar'), $imageName);
            $user->image = $imageName;
        }

        // Đổi mật khẩu
        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'Mật khẩu cũ không chính xác.');
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }
}
