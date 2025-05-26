<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pay;
use App\Models\Bank;
use App\Models\Bill;
use App\Models\BillDetail;

class UserPayController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy danh sách thanh toán của tài khoản đang đăng nhập và có status = 0 (chờ thanh toán)
        $payments = Pay::whereHas('member', function ($query) use ($user) {
            $query->where('idUser', $user->id);
        })->where('status', 0)->with('member')->orderBy('created_at', 'desc')->get();

        return view('user.ThanhToan.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Lấy danh sách thanh toán đang chờ của user
        $payments = Pay::whereHas('member', function ($query) use ($user) {
            $query->where('idUser', $user->id);
        })->where('status', 0)->get();

        if ($payments->isEmpty()) {
            return redirect()->back()->with('error', 'Không có khoản nào cần thanh toán.');
        }

        // Tính tổng tiền
        $totalPrice = $payments->sum('price');

        // Tạo Bill mới
        $bill = Bill::create([
            'idUser' => $user->id,
            'totalPrice' => $totalPrice,
            'content' => '', // Tạo trước, chưa có ID
            'status' => 0, // Chờ xác nhận
            'pttt' => 'Online'
        ]);

        // Cập nhật content với mã hóa đơn
        $bill->update([
            'content' => 'BVC2003' . $bill->id
        ]);

        // Tạo BillDetail và xóa Pay sau khi tạo hóa đơn
        foreach ($payments as $pay) {
            BillDetail::create([
                'idBill' => $bill->id,
                'idPay' => $pay->id,
                'price' => $pay->price
            ]);

            // Cập nhật trạng thái của khoản thanh toán
            $pay->update(['status' => 3]); // Xử lý

            // Xóa dữ liệu trong bảng Pay
            $pay->delete();
        }

        // Chuyển hướng sang trang hóa đơn chi tiết
        return redirect()->route('user.billDetail', ['id' => $bill->id])->with('success', 'Quét mã QR để thanh toán!');
    }

    public function bill()
    {
        $user = Auth::user();

        // Lấy danh sách hóa đơn của tài khoản hiện tại, sắp xếp theo thời gian mới nhất
        $bills = Bill::where('idUser', $user->id)->orderBy('created_at', 'desc')->get();

        // Tính toán các thông tin thống kê
        $totalBills = $bills->count();
        $totalBillsSuccess = $bills->where('status', 1)->count();
        $totalBillsPending = $bills->where('status', 0)->count();
        $totalPriceSuccess = $bills->where('status', 1)->sum('totalPrice');
        $totalPricePending = $bills->where('status', 0)->sum('totalPrice');

        return view('user.HoaDon.index', compact(
            'bills',
            'totalBills',
            'totalBillsSuccess',
            'totalBillsPending',
            'totalPriceSuccess',
            'totalPricePending'
        ));
    }

    public function billDetail($id)
    {
        $user = Auth::user();
        $bank = Bank::where('bank', 'MBBank')->first();

        // Lấy hóa đơn theo ID và kiểm tra quyền truy cập
        $bill = Bill::where('id', $id)->where('idUser', $user->id)->firstOrFail();

        // Lấy chi tiết hóa đơn
        $billDetails = BillDetail::where('idBill', $bill->id)->with('bill')->get();

        return view('user.HoaDon.detail', compact('bill', 'billDetails', 'bank'));
    }
}
