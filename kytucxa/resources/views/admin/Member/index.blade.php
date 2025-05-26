@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchMember') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin danh mục cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createMember') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">

        {{-- Thống kê số lượng thành viên theo từng phòng --}}
        @php
        $roomCounts = [];
        foreach ($members as $member) {
        $roomName = $member->room->name ?? 'Chưa có phòng';
        if (!isset($roomCounts[$roomName])) {
        $roomCounts[$roomName] = 0;
        }
        $roomCounts[$roomName]++;
        }
        @endphp

        {{-- Bảng thống kê --}}
        <div class="mb-4">
            <h5>Thống kê số thành viên theo phòng</h5>
            <table class="table table-bordered table-striped" id="room-summary">
                <thead class="table-light">
                    <tr>
                        <th>Phòng</th>
                        <th>Số lượng thành viên</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomCounts as $room => $count)
                    <tr class="room-row" data-room="{{ $room }}">
                        <td class="text-primary" style="cursor: pointer;">{{ $room }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-secondary btn-sm" id="show-all">Hiện tất cả</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Bảng danh sách thành viên --}}
        <table class="table table-bordered table-hover" id="member-table">
            <thead class="table-light">
                <tr>
                    <th>STT</th> <!-- Thêm cột STT -->
                    <th>MSV</th>
                    <th>Tên</th>
                    <th>Phòng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $index => $member) <!-- Sử dụng $index để lấy số thứ tự -->
                @php
                $roomName = $member->room->name ?? 'Chưa có phòng';
                @endphp
                <tr class="member-row" data-room="{{ $roomName }}">
                    <td>{{ $index + 1 }}</td> <!-- Hiển thị STT -->
                    <td>{{ $member->msv }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $roomName }}</td>
                    <td>
                        @if($member->status == 0)
                        <span class="badge bg-success">Đang ở KTX</span>
                        @elseif($member->status == 1)
                        <span class="badge bg-danger">Ngừng hoạt động</span>
                        @elseif($member->status == 3)
                        <span class="badge bg-warning">Chờ duyệt hủy KTX</span>
                        @else
                        <span class="badge bg-warning">Chờ duyệt ĐK KTX</span>
                        @endif
                    </td>
                    <td>
                        <a style="margin-right: 10px;" href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $member->id }}')">Xóa</a>
                        <a style="margin-right: 10px;" href="{{ route('admin.editMember', $member->id) }}" class="">Sửa</a>
                        <a style="margin-right: 10px;" href="{{ route('admin.showMember', $member->id) }}" class="">Thông tin sinh viên</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Không có thành viên nào.</td> <!-- Cập nhật colspan thành 6 -->
                </tr>
                @endforelse
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
                Bạn có chắc chắn muốn xóa thành viên này không?
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
        form.action = "{{ route('admin.deleteMember', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    //lọc 
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll(".room-row");
        const memberRows = document.querySelectorAll(".member-row");
        const showAllBtn = document.getElementById("show-all");

        rows.forEach(row => {
            row.addEventListener("click", () => {
                const room = row.getAttribute("data-room");
                memberRows.forEach(mr => {
                    if (mr.getAttribute("data-room") === room) {
                        mr.style.display = "";
                    } else {
                        mr.style.display = "none";
                    }
                });
            });
        });

        if (showAllBtn) {
            showAllBtn.addEventListener("click", () => {
                memberRows.forEach(mr => mr.style.display = "");
            });
        }
    });
</script>

@endsection