<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function login() {
        return view('user.Account.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.index')->with('success', 'Đăng nhập thành công!');
        } else {
            return redirect()->route('login')->with('error', 'Thông tin sai hoặc tài khoản không tồn tại!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất.');
    }

    // Đăng ký 
    public function register() {
        return view('user.Account.register');
    }

    // Xử lý đăng ký
    public function handleRegister(Request $request)
    {
        $request->validate([
            'msv' => 'required|string|max:20|unique:users,msv',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:6|regex:/[A-Z]/|regex:/[0-9]/',
            'tel' => 'nullable|string|max:15',
            'date' => 'required|date',
            'cccd' => 'nullable|string|max:20',
            'sex' => 'nullable|string|max:10',
            'address' => 'required|string|max:255',
        ]);

        $code = str_pad(random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);

        $user = User::create([
            'msv' => $request->msv,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'date' => $request->date,
            'address' => $request->address,
            'status' => 1, // 0 - Hoạt động, 1 - Ngừng hoạt động
            'role' => 2, // 0 - Quản trị, 1 - Nhân viên, 2 - Người dùng
            'competence' => 1, 
            'cccd' => $request->cccd,
            'sex' => $request->sex,
            'code' => $code,
        ]);

        Mail::raw("Mã xác thực của bạn là: $code", function ($message) use ($request) {
            $message->to($request->email)->subject('Xác thực tài khoản');
        });

        session(['email' => $request->email]);

        return redirect()->route('user.verifyCode');
    }

    public function verifyCode()
    {
        return view('user.Account.verify');
    }

    public function handleVerifyCode(Request $request)
    {
        $request->validate(['code' => 'required|size:8']);

        $user = User::where('email', session('email'))->where('code', $request->code)->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Mã xác thực không hợp lệ!']);
        }

        $user->update(['status' => 0, 'code' => null]);

        session()->forget('email');

        // Lỗi sửa success về status
        return redirect()->route('login')->with('success', 'Xác thực thành công! Hãy đăng nhập.');
    }

    public function deleteTempAccount()
    {
        $user = User::where('email', session('email'))->where('status', 1)->first();

        if ($user) {
            $user->delete();
            session()->forget('email');
        }

        return response()->json(['message' => 'Tài khoản tạm thời đã bị xóa do không xác thực.']);
    }


    // Trang quên mật khẩu
    public function forgot_pwd() {
        return view('user.Account.forgot_pwd');
    }

    public function sendResetPassword(Request $request)
    {
        // Validate email và tel
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'tel' => 'required|digits_between:9,11|exists:users,tel',
        ]);

        $user = User::where('email', $request->email)->where('tel', $request->tel)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Thông tin không chính xác!');
        }

        $newPassword = Str::random(8);

        $user->update(['password' => Hash::make($newPassword)]);

        Mail::raw("Mật khẩu mới của bạn là: {$newPassword}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Khôi phục mật khẩu')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        return redirect()->route('login')->with('success', 'Đã gửi mật khẩu mới về email của bạn!');
    }
}