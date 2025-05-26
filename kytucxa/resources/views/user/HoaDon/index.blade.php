@extends('layouts.user')

@section('content')
<div class="container pt-4 pb-4">
    <div class="user_titles mb-4">
        <span>
            <a href="{{ route('user.index') }}">Trang chủ</a>
        </span>
        <span>/ Hóa đơn</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div style="height: 150px;" class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-receipt-fill text-primary me-2"></i> Tổng số hóa đơn</h5>
                    <p class="card-text fw-bold fs-3 text-primary">{{ $totalBills }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="height: 150px;" class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-check-circle-fill text-success me-2"></i> Đã thanh toán</h5>
                    <p class="card-text fw-bold fs-3 text-success">{{ $totalBillsSuccess }}</p>
                    <p class="card-text text-muted">Tổng tiền: {{ number_format($totalPriceSuccess, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="height: 150px;" class="card border-warning shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Chờ xử lý</h5>
                    <p class="card-text fw-bold fs-3 text-warning">{{ $totalBillsPending }}</p>
                    <p class="card-text text-muted">Tổng tiền: {{ number_format($totalPricePending, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <h6>Danh sách hóa đơn</h6>
        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>STT</th>
                    <th>Mã hóa đơn</th>
                    <th>Số tiền</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Thời gian thanh toán</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $key => $bill)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $bill->id }}</td>
                        <td>{{ number_format($bill->totalPrice, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $bill->content ?? 'Không có' }}</td>
                        <td>
                            @if($bill->status == 0)
                                <span class="badge bg-warning">Chờ xử lý</span>
                            @elseif($bill->status == 1)
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>{{ $bill->transactionDate }}</td>
                        <td>
                            <a href="{{ route('user.billDetail', $bill->id) }}" class="btn btn-info btn-sm">Xem</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có hóa đơn nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection