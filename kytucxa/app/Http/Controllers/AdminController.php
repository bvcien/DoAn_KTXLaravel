<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Room;
use App\Models\Bill;
use App\Models\Category;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Lấy 10 thành viên mới nhất
        $latestMembers = Member::latest()->take(10)->get();

        // Lấy 10 phòng mới nhất
        $latestRooms = Room::latest()->take(10)->get();

        // Lọc dữ liệu theo thời gian cho doanh thu
        $timeFilter = $request->input('time_filter', '10_days'); // Mặc định 10 ngày gần nhất

        $query = Bill::where('status', 1);

        if ($timeFilter == '10_days') {
            $query->whereDate('created_at', '>=', Carbon::now()->subDays(10));
        } elseif ($timeFilter == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($timeFilter == 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $revenues = $query->selectRaw('DATE(created_at) as date, SUM(totalPrice) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Lấy số lượng phòng theo danh mục và số lượng thành viên trong mỗi phòng
        $categoryRoomCounts = Category::withCount('rooms')
            ->with(['rooms' => function ($query) {
                $query->withCount('members');
            }])
            ->get();

        return view('admin.index', compact('latestMembers', 'latestRooms', 'revenues', 'timeFilter', 'categoryRoomCounts'));
    }
}
