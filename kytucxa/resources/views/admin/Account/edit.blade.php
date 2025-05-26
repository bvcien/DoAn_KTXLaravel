@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Sửa tài khoản</h3>

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updateAccount', $user->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="msv">Mã sinh viên: <span>*</span></label>
                <input type="text" id="msv" class="form-control mt-2" name="msv" value="{{ $user->msv }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="name">Họ và tên: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="cccd">CCCD: <span>*</span></label>
                <input type="text" id="cccd" class="form-control mt-2" name="cccd" value="{{ $user->cccd }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="sex">Giới tính: <span>*</span></label>
                <select class="form-select mt-3" name="sex" required>
                    <option value="0" {{ $user->sex == 0 ? 'selected' : '' }}>Nam</option>
                    <option value="1" {{ $user->sex == 1 ? 'selected' : '' }}>Nữ</option>
                    <option value="2" {{ $user->sex == 2 ? 'selected' : '' }}>Khác</option>
                </select>
            </div>

            {{-- Quyền thao tác --}}
            <div class="form-group mb-3">
                <label for="competence">Quyền thao tác: <span>*</span></label>
                @if ($loggedInUser->role == 1)
                    <input type="text" class="form-control mt-2" value="{{ $user->competence == 0 ? 'Có quyền' : 'Không quyền' }}" readonly>
                    <input type="hidden" name="competence" value="{{ $user->competence }}">
                @else
                    <select class="form-select mt-3" name="competence" required>
                        <option value="0" {{ $user->competence == 0 ? 'selected' : '' }}>Có quyền</option>
                        <option value="1" {{ $user->competence == 1 ? 'selected' : '' }}>Không quyền</option>
                    </select>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="email">Email: <span>*</span></label>
                <input type="email" id="email" class="form-control mt-2" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image">
                @if($user->image)
                <img src="{{ asset('Avatar/' . $user->image) }}" class="mt-2" alt="" width="100">
                @else
                <p>Chưa có hình ảnh</p>
                @endif
            </div>
            <div class="form-group mb-3">
                <label for="password">Mật khẩu mới (để trống nếu không đổi):</label>
                <input type="password" id="password" class="form-control mt-2" name="password">
            </div>
            <div class="form-group mb-3">
                <label for="tel">Số điện thoại:</label>
                <input type="text" id="tel" class="form-control mt-2" name="tel" value="{{ $user->tel }}">
            </div>
            <div class="form-group mb-3">
                <label for="date">Ngày sinh: <span>*</span></label>
                <input type="date" id="date" class="form-control mt-2" name="date" value="{{ $user->date }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ: <span>*</span></label>
                <input type="text" id="address" class="form-control mt-2" name="address" value="{{ $user->address }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Ngừng hoạt động</option>
                </select>
            </div>

            {{-- Quyền hạn --}}
            <div class="form-group mb-3">
                <label for="role">Quyền hạn: <span>*</span></label>
                @if ($loggedInUser->role == 1)
                    <select class="form-select mt-3" name="role" required>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Nhân viên</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Người dùng</option>
                    </select>
                @elseif ($loggedInUser->role == 0 && $loggedInUser->email == 'admin@gmail.com')
                    <select class="form-select mt-3" name="role" required>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Quản trị</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Nhân viên</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Người dùng</option>
                    </select>
                @else
                    <input type="text" class="form-control mt-2" value="{{ $user->role == 0 ? 'Quản trị' : ($user->role == 1 ? 'Nhân viên' : 'Người dùng') }}" readonly>
                    <input type="hidden" name="role" value="{{ $user->role }}">
                @endif
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexAccount') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection