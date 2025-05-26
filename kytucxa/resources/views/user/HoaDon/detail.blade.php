@extends('layouts.user')

@section('content')
<div class="container pt-4 pb-4">
    <div class="user_titles mb-4">
        <span>
            <a href="{{ route('user.index') }}">Trang chủ</a>
        </span>
        <span>/ <a href="{{ route('user.billHoaDon') }}">Hóa đơn</a></span>
        <span>/ Chi tiết hóa đơn</span>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>Chi tiết hóa đơn #HD {{ $bill->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Tổng tiền:</strong> {{ number_format($bill->totalPrice, 0, ',', '.') }} VNĐ</p>
            <p><strong>Nội dung:</strong> {{ $bill->content ?? 'Không có' }}</p>
            <p><strong>Ngày tạo:</strong> {{ $bill->transactionDate }}</p>
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

    <h6>Chi tiết thanh toán</h6>
    <div class="row">
        <div class="col-md-9">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Khoản thanh toán</th>
                            <th>Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($billDetails as $key => $detail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>Thanh toán #{{ $detail->idPay }}</td>
                                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3">
            <div class="hoadon_qr">
                @if ($bill->status == 1)
                    <center>
                        <h5>Đã thanh toán</h5>
                    </center>
                @else
                    @if ($bank)
                        <img src="https://img.vietqr.io/image/{{ $bank->bank }}-{{ $bank->stk }}-qr.png?amount={{ $bill->totalPrice }}&addInfo={{ urlencode($bill->content) }}" alt="">
                    @else
                        <p>Không tìm thấy thông tin ngân hàng MBBank.</p>
                    @endif
                @endif
            </div>
        </div>
    </div> 

    <div class="mt-3">
        <a href="{{ route('user.billHoaDon') }}" class="btn btn-secondary">Quay lại</a>
    </div>

</div>

@endsection
