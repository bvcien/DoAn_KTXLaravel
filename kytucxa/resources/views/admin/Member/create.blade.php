@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm thành viên (Kí Túc Xá)</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeMember') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="idUser">Người dùng: </label>
                <select class="form-select mt-3" name="idUser" id="idUser" required>
                    <option value="">Chọn người dùng</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                                data-name="{{ $user->name }}" 
                                data-msv="{{ $user->msv }}">
                            {{ $user->email }} - {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="idRoom">Phòng KTX: <span>*</span></label>
                <select class="form-select mt-3" name="idRoom" required>
                    <option value="">Chọn phòng KTX</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="name">Họ tên: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ old('name') }}" required readonly>
            </div>

            <div class="form-group mb-3">
                <label for="msv">Mã sinh viên: <span>*</span></label>
                <input type="text" id="msv" class="form-control mt-2" name="msv" value="{{ old('msv') }}" required readonly>
            </div>

            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0">Đang ở KTX</option>
                    <option value="2">Chờ duyệt ĐK KTX</option>
                    <option value="3">Chờ duyệt hủy KTX</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
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

        userSelect.addEventListener("change", function() {
            let selectedOption = userSelect.options[userSelect.selectedIndex];
            let name = selectedOption.getAttribute("data-name") || "";
            let msv = selectedOption.getAttribute("data-msv") || "";

            nameInput.value = name;
            msvInput.value = msv;
        });
    });
</script>

@endsection
