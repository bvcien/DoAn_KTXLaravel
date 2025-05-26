@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Sửa thông tin thành viên (Kí Túc Xá)</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updateMember', $member->id) }}">
            @csrf
            <div class="form-group mb-3">
                <label for="idUser">Người dùng: </label>
                <input type="text" class="form-control mt-2" value="{{ $member->user->email }} - {{ $member->user->name }}" readonly>
                <input type="hidden" name="idUser" value="{{ $member->user->id }}">
            </div>

            <div class="form-group mb-3">
                <label for="idRoom">Phòng KTX: <span>*</span></label>
                <select class="form-select mt-3" name="idRoom" required>
                    <option value="">Chọn phòng KTX</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $member->idRoom == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="name">Họ tên: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ $member->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="msv">Mã sinh viên: <span>*</span></label>
                <input type="text" id="msv" class="form-control mt-2" name="msv" value="{{ $member->msv }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0" {{ $member->status == 0 ? 'selected' : '' }}>Đang ở KTX</option>
                    <option value="2" {{ $member->status == 2 ? 'selected' : '' }}>Chờ duyệt ĐK KTX</option>
                    <option value="3" {{ $member->status == 3 ? 'selected' : '' }}>Chờ duyệt hủy KTX</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexMember') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let userSelect = document.getElementById("idUser");
        let nameInput = document.getElementById("name");
        let msvInput = document.getElementById("msv");

        function updateUserData() {
            let selectedOption = userSelect.options[userSelect.selectedIndex];
            let name = selectedOption.getAttribute("data-name") || "";
            let msv = selectedOption.getAttribute("data-msv") || "";

            nameInput.value = name;
            msvInput.value = msv;
        }

        // Gán sự kiện change khi chọn user mới
        userSelect.addEventListener("change", updateUserData);

        // Cập nhật dữ liệu ban đầu khi trang tải lại
        updateUserData();
    });
</script>

@endsection