@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchRoom') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin tài khoản cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createRoom') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Danh mục</th>
                    <th>Phòng</th>
                    <th>Hình ảnh</th>
                    <th>Thông tin</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->category ? $room->category->name : 'Không xác định' }}</td>
                    <td>{{ $room->name }}</td>
                    <td>
                        @if($room->image)
                            <img src="{{ asset('Room/' . $room->image) }}" alt="Hình ảnh" width="60">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>
                        <p>Số lượng: {{ $room->quantity }}</p>
                        <p>Giá tiền / tháng: {{ number_format($room->price, 0, ',', '.') }} VNĐ</p>
                        <p>Mô tả: {{ $room->description }}</p>
                        <p>Loại phòng: {{ $room->type }}</p>
                        <p>Trạng thái: 
                            @if($room->status == 0)
                                <span class="badge bg-success">Hoạt động</span>
                            @elseif($room->status == 1)
                                <span class="badge bg-danger">Ngừng hoạt động</span>
                            @else
                                <span class="badge bg-warning">Bảo trì</span>
                            @endif
                        </p>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $room->id }}')">Xóa</a>
                        <a href="{{ route('admin.editRoom', $room->id) }}" class="">Sửa</a>
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
                Bạn có chắc chắn muốn xóa phòng này không?
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
        form.action = "{{ route('admin.deleteRoom', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection
