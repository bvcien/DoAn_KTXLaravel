@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <a href="{{ route('admin.indexMember') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách thành viên
        </a>
    </div>

    <div class="admin-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        Thông tin sinh viên
                    </div>
                    <div class="card-body">
                        <p><strong>MSV:</strong> {{ $member->user->msv }}</p>
                        <p><strong>Họ tên:</strong> {{ $member->user->name }}</p>
                        <p><strong>Ngày sinh:</strong> {{ $member->user->date }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $member->user->address }}</p>
                        <p><strong>Tel:</strong> {{ $member->user->tel }}</p>
                        <p><strong>CCCD/CMND:</strong> {{ $member->user->cccd }}</p>
                        <p><strong>Phòng ở:</strong> {{ $member->room->name ?? 'Chưa có phòng' }}</p>
                        <p>
                            <strong>Trạng thái ở KTX:</strong>
                            @if($member->status == 0)
                                <span class="badge bg-success">Đang ở KTX</span>
                            @elseif($member->status == 1)
                                <span class="badge bg-danger">Ngừng hoạt động</span>
                            @elseif($member->status == 3)
                                <span class="badge bg-warning">Chờ duyệt hủy KTX</span>
                            @else
                                <span class="badge bg-warning">Chờ duyệt ĐK KTX</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        Thống kê hóa đơn
                    </div>
                    <div class="card-body">
                        <p><strong>Tổng số tiền đã thanh toán:</strong> {{ number_format($totalPaid) }} VNĐ</p>
                        <p><strong>Tổng số tiền cần thanh toán:</strong> {{ number_format($totalUnpaid) }} VNĐ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                Danh sách hóa đơn
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Hóa đơn</th>
                            <th>Nội dung</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $bill)
                            <tr>
                                <td>{{ $bill->id }}</td>
                                <td>{{ $bill->content }}</td>
                                <td>{{ number_format($bill->totalPrice) }} VNĐ</td>
                                <td>
                                    @if($bill->status == 0)
                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                    @elseif($bill->status == 1)
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($bill->status == 2)
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có hóa đơn.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection