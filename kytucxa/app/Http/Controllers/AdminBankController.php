<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminBankController extends Controller
{
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập và có role là 0 (Quản trị)
        if (Auth::check() && Auth::user()->role == 0) {
            $banks = Bank::all();
            return view('admin.Bank.index', compact('banks'));
        } else {
            // Nếu không phải quản trị viên, chuyển hướng về trang khác (ví dụ: trang chủ)
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $banks = Bank::where('bank', 'like', "%{$search}%")
            ->orWhere('stk', 'like', "%{$search}%")
            ->orWhere('ctk', 'like', "%{$search}%")
            ->orWhere('taikhoan', 'like', "%{$search}%")
            ->get();
        return view('admin.Bank.index', compact('banks'));
    }

    public function delete($id)
    {
        $bank = Bank::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            $bank->delete();
            return redirect()->route('admin.indexBank')->with('success', 'Xóa banks thành công.');
        } else {
            return redirect()->route('admin.indexBank')->with('error', 'Bạn không có quyền xóa.');
        }
       
    }

    public function create()
    {
        return view('admin.Bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'stk' => 'required',
            'ctk' => 'required',
            'taikhoan' => 'required',
            'matkhau' => 'required',
        ]);

        $existingBank = Bank::where('bank', 'MBBank')->first();

        if ($existingBank) {
            return redirect()->route('admin.createBank')->with('error', 'MBBank đã tồn tại.');
        }

        Bank::create([
            'bank' => $request->bank,
            'stk' => $request->stk,
            'ctk' => $request->ctk,
            'taikhoan' => $request->taikhoan,
            'matkhau' => $request->matkhau, 
        ]);

        return redirect()->route('admin.indexBank')->with('success', 'Thêm Bank thành công.');
    }

    public function checkApi(Bank $bank)
    {
        // Lấy dữ liệu từ API ngân hàng
        try {
            $response = Http::get('https://apicanhan.com/api/mbbank', [
                'key' => '4ea64fd3a515b8942cf39610e436b6b0',
                'username' => $bank->taikhoan,
                'password' => $bank->matkhau . '25',
                'accountNo' => $bank->stk,
            ]);

            $jsonData = $response->json();
        } catch (\Exception $e) {
            $jsonData = ['error' => 'Không thể kết nối đến API ngân hàng. Vui lòng kiểm tra lại.'];
        }

        return view('admin.Bank.check_api', compact('jsonData', 'bank'));
    }
}