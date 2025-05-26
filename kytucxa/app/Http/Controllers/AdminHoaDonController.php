<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use App\Models\Pay;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminHoaDonController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with('user')->orderBy('id', 'desc');

        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm)
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('email', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    });
            });
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('from_date') && $request->from_date != '' && $request->has('to_date') && $request->to_date != '') {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($request->has('from_date') && $request->from_date != '') {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $query->where('created_at', '>=', $fromDate);
        } elseif ($request->has('to_date') && $request->to_date != '') {
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $query->where('created_at', '<=', $toDate);
        }

        $bills = $query->paginate(10)->withQueryString();

        // Tính tổng doanh thu theo trạng thái
        $totalRevenueByStatus = Bill::query();

        // Áp dụng lại các điều kiện lọc và tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $totalRevenueByStatus->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm)
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('email', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $totalRevenueByStatus->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date != '' && $request->has('to_date') && $request->to_date != '') {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $totalRevenueByStatus->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($request->has('from_date') && $request->from_date != '') {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $totalRevenueByStatus->where('created_at', '>=', $fromDate);
        } elseif ($request->has('to_date') && $request->to_date != '') {
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $totalRevenueByStatus->where('created_at', '<=', $toDate);
        }

        $totalRevenueByStatus = $totalRevenueByStatus->selectRaw('status, SUM(totalPrice) as total_revenue')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return view('admin.HoaDon.index', compact('bills', 'totalRevenueByStatus'));
    }

    public function edit($id)
    {
        $bill = Bill::with('details')->findOrFail($id);
        return view('admin.HoaDon.edit', compact('bill'));
    }

    public function update(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);
        
        // Cập nhật trạng thái của hóa đơn
        $bill->update([
            'status' => $request->status,
        ]);
    
        // Lấy danh sách BillDetail liên quan
        $billDetails = BillDetail::where('idBill', $id)->get();
    
        // Duyệt qua từng BillDetail để cập nhật trạng thái của Pay
        foreach ($billDetails as $detail) {
            Pay::where('id', $detail->idPay)->update(['status' => $request->status]);
        }
    
        return redirect()->route('admin.indexHoaDon')->with('success', 'Cập nhật trạng thái thành công.');
    }    

    public function delete($id)
    {
        $bill = Bill::findOrFail($id);
        $user = Auth::user();

        if ($user->competence == 0) {
            $bill->delete();

            return redirect()->route('admin.indexHoaDon')->with('success', 'Xóa hóa đơn thành công.');
        } else {
            return redirect()->route('admin.indexHoaDon')->with('error', 'Bạn không có quyền xóa.');
        }
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function show($id)
    {
        $bill = Bill::with('user', 'details.pay.member')->findOrFail($id);
    
        return view('admin.HoaDon.show', compact('bill'));
    }

    public function exportExcel(Request $request)
    {
        $query = Bill::with('user');
    
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            })->orWhere('id', 'like', '%' . $request->search . '%');
        }
    
        $bills = $query->orderBy('id', 'desc')->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Tiêu đề cột
        $sheet->setCellValue('A1', 'Mã HĐ');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Họ tên');
        $sheet->setCellValue('D1', 'Tổng tiền');
        $sheet->setCellValue('E1', 'PTTT');
        $sheet->setCellValue('F1', 'Nội dung');
        $sheet->setCellValue('G1', 'Trạng thái');
    
        $row = 2;
        foreach ($bills as $bill) {
            $sheet->setCellValue("A{$row}", $bill->id);
            $sheet->setCellValue("B{$row}", $bill->user->email ?? 'N/A');
            $sheet->setCellValue("C{$row}", $bill->user->name ?? 'N/A');
            $sheet->setCellValue("D{$row}", $bill->totalPrice);
            $sheet->setCellValue("E{$row}", $bill->pttt);
            $sheet->setCellValue("F{$row}", $bill->content);
            $sheet->setCellValue("G{$row}", $this->getStatusText($bill->status));
            $row++;
        }
    
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Danh_sach_hoa_don.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
    
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
    
    private function getStatusText($status)
    {
        return match ($status) {
            0 => 'Chưa thanh toán',
            1 => 'Hoàn thành',
            default => 'Đã hủy',
        };
    }
}
