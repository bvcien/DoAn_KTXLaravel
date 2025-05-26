@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">Trang Báo Cáo & Thống Kê</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5>Thành viên mới nhất</h5>
                </div>
                <div class="card-body">
                    <div style="overflow-y: auto; height: 300px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Mã SV</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestMembers as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->msv }}</td>
                                    <td>
                                        <span class="badge {{ $member->status == 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $member->status == 0 ? 'Đang ở KTX' : 'Chờ duyệt & không ở KTX' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5>Phòng mới nhất</h5>
                </div>
                <div class="card-body">
                    <div style="overflow-y: auto; height: 300px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên phòng</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestRooms as $room)
                                <tr>
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->quantity }}</td>
                                    <td>{{ number_format($room->price, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="mt-4 card shadow">
        <div class="card-header bg-secondary text-white">
            <h5>Thống kê số lượng phòng</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($categoryRoomCounts as $category)
                @php
                    $totalRooms = $category->rooms_count;
                    $availableRooms = $category->rooms->filter(function ($room) {
                        return $room->members_count < $room->quantity;
                    });
                    $fullRooms = $category->rooms->filter(function ($room) {
                        return $room->members_count >= $room->quantity;
                    });
                    $availableRoomsCount = $availableRooms->count();
                    $fullRoomsCount = $fullRooms->count();
                @endphp
                <div class="col-md-4 mb-3">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h6 class="card-title">{{ $category->name }}</h6>
                            <p class="card-text">
                                Tổng số phòng: <span class="badge bg-primary">{{ $totalRooms }}</span><br>
                                Phòng còn trống: <span class="badge bg-success">{{ $availableRoomsCount }}</span><br>
                                Phòng đã hết chỗ: <span class="badge bg-danger">{{ $fullRoomsCount }}</span>
                            </p>

                            <div class="mt-2">
                                <div class="card card-body" style="overflow-y: auto; height: 230px;">
                                    <h6 class="card-title">Danh sách phòng còn trống - {{ $category->name }}</h6>
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tên phòng</th>
                                                <th>Số lượng tối đa</th>
                                                <th>Hiện có</th>
                                                <th>Còn trống</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($availableRooms as $room)
                                            <tr>
                                                <td>{{ $room->name }}</td>
                                                <td>{{ $room->quantity }}</td>
                                                <td>{{ $room->members_count }}</td>
                                                <td>{{ $room->quantity - $room->members_count }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3">Không có phòng nào còn trống.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="card card-body" style="overflow-y: auto; height: 230px;">
                                    <h6 class="card-title">Danh sách phòng đã hết chỗ - {{ $category->name }}</h6>
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tên phòng</th>
                                                <th>Số lượng tối đa</th>
                                                <th>Hiện có</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($fullRooms as $room)
                                            <tr>
                                                <td>{{ $room->name }}</td>
                                                <td>{{ $room->quantity }}</td>
                                                <td>{{ $room->members_count }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3">Không có phòng nào hết chỗ.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h5>Biểu đồ tổng doanh thu</h5>
                    <form action="{{ route('admin.index') }}" method="GET">
                        <select name="time_filter" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                            <option value="10_days" {{ $timeFilter == '10_days' ? 'selected' : '' }}>10 ngày gần nhất</option>
                            <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>Tháng hiện tại</option>
                            <option value="year" {{ $timeFilter == 'year' ? 'selected' : '' }}>Năm hiện tại</option>
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5>Tỷ lệ phòng theo danh mục</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="categoryRoomChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                @foreach($categoryRoomCounts as $category)
                                <li><i class="fas fa-circle me-2" style="color: {{ '#' . substr(md5($category->name), 0, 6) }}"></i> {{ $category->name }} ({{ $category->rooms_count }} phòng)</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Biểu đồ doanh thu
        var ctxRevenue = document.getElementById("revenueChart").getContext("2d");
        var revenueData = {
            labels: {!! json_encode($revenues->pluck('date')) !!},
            datasets: [{
                label: "Doanh thu (VNĐ)",
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 2,
                data: {!! json_encode($revenues->pluck('total')) !!}
            }]
        };
        
        new Chart(ctxRevenue, {
            type: "bar",
            data: revenueData,
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: "Ngày" } },
                    y: { beginAtZero: true, title: { display: true, text: "Doanh thu (VNĐ)" } }
                }
            }
        });

        // Biểu đồ tròn số lượng phòng theo danh mục
        var ctxCategoryRoom = document.getElementById("categoryRoomChart").getContext("2d");
        var categoryLabels = {!! json_encode($categoryRoomCounts->pluck('name')) !!};
        var categoryData = {!! json_encode($categoryRoomCounts->pluck('rooms_count')) !!};

        var backgroundColors = [
            '#90EE90', 
            '#00008B', 
            '#00CED1'  
            // Thêm màu sắc khác nếu bạn có thêm danh mục
        ];

        var categoryRoomData = {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: backgroundColors,
                hoverOffset: 4
            }]
        };

        new Chart(ctxCategoryRoom, {
            type: 'pie',
            data: categoryRoomData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false, 
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += `: ${context.parsed} phòng (${(context.percent*100).toFixed(2)}%)`;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection