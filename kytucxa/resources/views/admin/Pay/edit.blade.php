@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Sửa khoản thanh toán</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updatePay', $pay->id) }}">
            @csrf
            <div class="form-group mb-3">
                <label>Họ tên: <span>*</span></label>
                <input type="text" class="form-control mt-2" value="{{ $pay->member->name ?? 'Không có' }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="time_at">Thời gian tạo: <span>*</span></label>
                <input type="date" id="time_at" class="form-control mt-2" name="time_at" 
                    value="{{ \Carbon\Carbon::parse($pay->time_at)->format('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="time_out">Thời gian hết hạn: <span>*</span></label>
                <input type="date" id="time_out" class="form-control mt-2" name="time_out" 
                    value="{{ \Carbon\Carbon::parse($pay->time_out)->format('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="note">Ghi chú:</label>
                <textarea id="note" class="form-control mt-2" name="note" rows="3">{{ $pay->note }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0" {{ $pay->status == 0 ? 'selected' : '' }}>Chưa thanh toán</option>
                    <option value="1" {{ $pay->status == 1 ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="2" {{ $pay->status == 2 ? 'selected' : '' }}>Chờ xử lý</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexPay') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
