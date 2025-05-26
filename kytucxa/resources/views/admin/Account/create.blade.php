@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm tài khoản</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeAccount') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="msv">Mã sinh viên: <span>*</span></label>
                <input type="text" id="msv" class="form-control mt-2" name="msv" required>
            </div>
            <div class="form-group mb-3">
                <label for="name">Họ và tên: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="cccd">CCCD: <span>*</span></label>
                <input type="text" id="cccd" class="form-control mt-2" name="cccd" required>
            </div>
            <div class="form-group mb-3">
                <label for="sex">Giới tính: <span>*</span></label>
                <select class="form-select mt-3" name="sex" required>
                    <option value="0">Nam</option>
                    <option value="1">Nữ</option>
                    <option value="2">Khác</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="competence">Quyền thao tác: <span>*</span></label>
                <select class="form-select mt-3" name="competence" required>
                    <option value="0">Có quyền</option>
                    <option value="1">Không quyền</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email: <span>*</span></label>
                <input type="email" id="email" class="form-control mt-2" name="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image">
            </div>
            <div class="form-group mb-3">
                <label for="password">Mật khẩu: <span>*</span></label>
                <input type="password" id="password" class="form-control mt-2" name="password" required>
            </div>
            <div class="form-group mb-3">
                <label for="tel">Số điện thoại:</label>
                <input type="text" id="tel" class="form-control mt-2" name="tel">
            </div>
            <div class="form-group mb-3">
                <label for="date">Ngày sinh: <span>*</span></label>
                <input type="date" id="date" class="form-control mt-2" name="date" required>
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ: <span>*</span></label>
                <input type="text" id="address" class="form-control mt-2" name="address" required>
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0">Hoạt động</option>
                    <option value="1">Ngừng hoạt động</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="role">Quyền hạn: <span>*</span></label>
                <select class="form-select mt-3" name="role" required>
                    <option value="0">Quản trị</option>
                    <option value="1">Nhân viên</option>
                    <option value="2">Người dùng</option>
                </select>
            </div>
            
            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexAccount') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
