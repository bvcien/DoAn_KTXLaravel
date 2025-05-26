@extends('layouts.user')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-3 ">
            <div class="card p-3 text-center">
                <center>
                    <img src="{{ asset('Avatar/' . auth()->user()->image) }}" 
                        class="rounded-circle" width="150" height="150" alt="Avatar">
                </center>
                <h5 class="mt-3 fw-bold">{{ auth()->user()->name }}</h5>
            </div>
        </div>

        <!-- Cột phải -->
        <div class="col-md-9">
            <div class="card p-4">
                <h4>Cài đặt tài khoản</h4>

                <form action="{{ route('user.updateSetting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->msv }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Căn cước công dân</label>
                        <input type="text" name="cccd" class="form-control" value="{{ auth()->user()->cccd }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-select" name="sex">
                            <option value="0" {{ auth()->user()->sex == '0' ? 'selected' : '' }}>Nam</option>
                            <option value="1" {{ auth()->user()->sex == '1' ? 'selected' : '' }}>Nữ</option>
                            <option value="2" {{ auth()->user()->sex == '2' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quyền hạn</label>
                        <select class="form-select" name="competence" disabled>
                            <option value="0" {{ auth()->user()->competence == '0' ? 'selected' : '' }}>Có</option>
                            <option value="1" {{ auth()->user()->competence == '1' ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="tel" class="form-control" value="{{ auth()->user()->tel }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="date" class="form-control" value="{{ auth()->user()->date }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->status == 0 ? 'Hoạt động' : 'Ngừng hoạt động' }}" disabled>
                    </div>

                    <hr>
                    <h5>Đổi mật khẩu</h5>
                    <p class="text-muted">Mật khẩu mới phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.</p>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu cũ</label>
                        <input type="password" name="old_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhập lại mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
