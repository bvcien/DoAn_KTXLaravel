<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Bank;

class BillApiController extends Controller
{
    public function index()
    {
        $bills = Bill::select('id', 'idUser', 'totalPrice', 'content', 'status', 'pttt', 'created_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $bills
        ]);
    }

    public function checkAndUpdateBills()
    {
        // Lấy tất cả hóa đơn
        $bills = Bill::where('status', 0)->get();
        $bank = Bank::where('bank', 'MBBank')->first();

        // Lấy dữ liệu từ API ngân hàng
        $response = Http::get('https://apicanhan.com/api/mbbank', [
            'key' => '4ea64fd3a515b8942cf39610e436b6b0',
            'username' => $bank->taikhoan,
            'password' => $bank->matkhau . '25',
            'accountNo' => $bank->stk,
        ]);

        $transactions = $response->json()['TranList'];

        // Kiểm tra và cập nhật trạng thái hóa đơn nếu có trùng khớp
        foreach ($bills as $bill) {
            foreach ($transactions as $transaction) {
                if (strpos($transaction['description'], $bill->content) !== false) {
                    // Nếu có trùng khớp, cập nhật trạng thái hóa đơn
                    $bill->update([
                        'status' => 1,
                        'transactionDate' => $transaction['transactionDate'],
                    ]);
                    break;
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
