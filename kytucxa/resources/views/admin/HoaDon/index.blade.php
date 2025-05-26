@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.indexHoaDon') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-auto">
                <div class="admin-search">
                    <button type="submit" class="search-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" placeholder="Nhập mã hóa đơn, email hoặc họ tên..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-auto">
                <select class="form-select" name="status">
                    <option value="">-- Chọn tất cả --</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa thanh toán</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="from_date" class="form-label">Từ ngày:</label>
                <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date') }}">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">Đến ngày:</label>
                <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </form>

        <a href="{{ route('admin.exportHoaDon', ['search' => request('search'), 'status' => request('status'), 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}" class="btn btn-success">
            <i class="fa-solid fa-file-excel"></i> Xuất Excel
        </a>

    </div>


    <div class="admin-body">
        <div class="mb-3">
            <h5>Tổng doanh thu theo trạng thái:</h5>
            <span style="margin-right: 10px;">
                <span class="badge bg-warning">Chưa thanh toán:</span>
                {{ number_format($totalRevenueByStatus[0]['total_revenue'] ?? 0, 0, ',', '.') }}đ
            </span>
            <span style="margin-right: 10px;">
                <span class="badge bg-success">Hoàn thành:</span>
                {{ number_format($totalRevenueByStatus[1]['total_revenue'] ?? 0, 0, ',', '.') }}đ
            </span>
            <span style="margin-right: 10px;">
                <span class="badge bg-danger">Đã hủy:</span>
                {{ number_format($totalRevenueByStatus[2]['total_revenue'] ?? 0, 0, ',', '.') }}đ
            </span>
            <span style="margin-right: 10px;">
                <span class="badge bg-info">Tổng cộng:</span>
                {{ number_format(($totalRevenueByStatus[0]['total_revenue'] ?? 0) + ($totalRevenueByStatus[1]['total_revenue'] ?? 0) + ($totalRevenueByStatus[2]['total_revenue'] ?? 0), 0, ',', '.') }}đ
            </span>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Mã HĐ</th>
                    <th>Email</th>
                    <th>Họ tên</th>
                    <th>Tổng tiền</th>
                    <th>PTTT</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $bill)
                <tr>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->user->email ?? 'N/A' }}</td>
                    <td>{{ $bill->user->name ?? 'N/A' }}</td>
                    <td>{{ number_format($bill->totalPrice, 0, ',', '.') }}đ</td>
                    <td>{{ $bill->pttt }}</td>
                    <td>{{ $bill->content }}</td>
                    <td>{{ $bill->transactionDate }}</td>
                    <td>
                        @if($bill->status == 0)
                        <span class="badge bg-warning">Chưa thanh toán</span>
                        @elseif($bill->status == 1)
                        <span class="badge bg-success">Hoàn thành</span>
                        @else
                        <span class="badge bg-danger">Đã hủy</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.showHoaDon', $bill->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                        <a href="{{ route('admin.editHoaDon', $bill->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $bill->id }}')">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $bills->links() }}
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa hóa đơn này không?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        let form = document.getElementById('deleteForm');
        form.action = "{{ route('admin.deleteHoaDon', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection