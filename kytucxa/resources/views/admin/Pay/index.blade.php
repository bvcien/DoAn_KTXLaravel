@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchPay') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin danh mục cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createPayRoom') }}" class="btn btn-primary">+ Thêm theo phòng</a>
        <a href="{{ route('admin.createPayMember') }}" class="btn btn-success">+ Thêm theo thành viên</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>STT</th> <!-- Thêm cột STT -->
                    <th>MSV</th>
                    <th>Họ tên</th>
                    <th>Số tiền</th>
                    <th>Thời gian</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pays as $index => $pay) <!-- Sử dụng $index để lấy số thứ tự -->
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Hiển thị STT -->
                    <td>{{ $pay->member->msv ?? 'Không có' }}</td>
                    <td>{{ $pay->member->name ?? 'Không có' }}</td>
                    <td>{{ number_format($pay->price, 0, ',', '.') }} VND</td>
                    <td>{{ date('d/m/Y', strtotime($pay->time_at)) }} - {{ date('d/m/Y', strtotime($pay->time_out)) }}</td>
                    <td>{{ $pay->note ?? 'Không có' }}</td>
                    <td>
                        @if($pay->status == 0)
                        <span class="badge bg-warning">Chưa thanh toán</span>
                        @elseif($pay->status == 1)
                        <span class="badge bg-success">Đã thanh toán</span>
                        @else
                        <span class="badge bg-secondary">Chờ xử lý</span>
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $pay->id }}')">Xóa</a>
                        <a href="{{ route('admin.editPay', $pay->id) }}" class="ms-2">Sửa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa khoản thanh toán này không?
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
        form.action = "{{ route('admin.deletePay', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection