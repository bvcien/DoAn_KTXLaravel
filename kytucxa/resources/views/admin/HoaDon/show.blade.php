@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chi tiết hóa đơn #{{ $bill->id }}</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Thông tin khách hàng</h5>
            <p><strong>Họ Tên:</strong> {{ $bill->user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $bill->user->email ?? 'N/A' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $bill->user->tel ?? 'N/A' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $bill->user->address ?? 'N/A' }}</p>
            <p><strong>Căn cước công dân:</strong> {{ $bill->user->cccd ?? 'N/A' }}</p>
            <p><strong>Giới tính:</strong> 
                @if($bill->user->sex == 0)
                    Nam
                @elseif($bill->user->sex == 1)
                    Nữ
                @elseif($bill->user->sex == 2)
                    Khác
                @else
                    N/A
                @endif
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Chi tiết hóa đơn</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Khoản thanh toán</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bill->details as $detail)
                    <tr>
                        <td>Thanh toán #{{ $detail->idPay }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-end"><strong>Tổng tiền:</strong> {{ number_format($bill->totalPrice, 0, ',', '.') }}đ</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Thông tin thanh toán</h5>
            <p><strong>Phương thức:</strong> {{ $bill->pttt }}</p>
            <p><strong>Nội dung:</strong> {{ $bill->content }}</p>
            <p><strong>Trạng thái:</strong> 
                @if($bill->status == 0)
                    <span class="badge bg-warning">Chờ xử lý</span>
                @elseif($bill->status == 1)
                    <span class="badge bg-success">Hoàn thành</span>
                @else
                    <span class="badge bg-danger">Đã hủy</span>
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('admin.indexHoaDon') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection