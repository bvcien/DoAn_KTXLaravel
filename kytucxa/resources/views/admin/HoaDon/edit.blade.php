@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa hóa đơn</h2>
    <form action="{{ route('admin.updateHoaDon', $bill->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Mã Hóa Đơn:</label>
            <input type="text" class="form-control" value="{{ $bill->id }}" disabled>
        </div>
        <div class="mb-3">
            <label>Họ Tên:</label>
            <input type="text" class="form-control" value="{{ $bill->user->name ?? 'N/A' }}" disabled>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="text" class="form-control" value="{{ $bill->user->email ?? 'N/A' }}" disabled>
        </div>
        <div class="mb-3">
            <label>Tổng Tiền:</label>
            <input type="text" class="form-control" value="{{ number_format($bill->totalPrice, 0, ',', '.') }}đ" disabled>
        </div>
        <div class="mb-3">
            <label>Trạng Thái:</label>
            <select class="form-control" name="status">
                <option value="0" {{ $bill->status == 0 ? 'selected' : '' }}>Chưa thành toán</option>
                <option value="1" {{ $bill->status == 1 ? 'selected' : '' }}>Hoàn thành</option>
                <option value="2" {{ $bill->status == 2 ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.indexHoaDon') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
