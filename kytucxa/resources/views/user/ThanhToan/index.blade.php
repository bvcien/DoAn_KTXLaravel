@extends('layouts.user')

@section('content')
<div class="container pt-4 pb-4">
    <div class="user_titles mb-4">
        <span>
            <a href="{{ route('user.index') }}">Trang chủ</a>
        </span>
        <span>/ Thanh toán</span>
    </div>

    <div class="">
        <div class="row">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>STT</th>
                                <th>Phòng</th>
                                <th>Số tiền</th>
                                <th>Thời gian</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @forelse($payments as $key => $pay)
                                @php $totalPrice += $pay->price; @endphp
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                        <input type="hidden" name="payments[]" value="{{ $pay->id }}">
                                    </td>
                                    <td>{{ $pay->member->room->name ?? 'Không xác định' }}</td>
                                    <td>{{ number_format($pay->price, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <p>Ngày bắt đầu: {{ date('d/m/Y', strtotime($pay->time_at)) }}</p>  
                                        <p>Ngày kết thúc: {{ date('d/m/Y', strtotime($pay->time_out)) }}</p>
                                    </td>
                                    <td>{{ $pay->note ?? 'Không có' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Không có khoản nào cần thanh toán</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Thông tin thanh toán</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Tài khoản:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <hr>
                        <p><strong>Tổng tiền:</strong> <span class="text-danger">{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</span></p>

                        <!-- Form thanh toán -->
                        <form action="{{ route('user.storeThanhToan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                            @foreach($payments as $pay)
                                <input type="hidden" name="payments[]" value="{{ $pay->id }}">
                            @endforeach
                            
                            <div class="mb-3">
                                <label for="payment_method" class="form-label"><strong>Phương thức thanh toán</strong></label>
                                <select class="form-control" name="pttt" id="payment_method">
                                    <option value="Online" selected>Online</option>
                                    <option value="Tiền mặt">Tiền mặt</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100" {{ $totalPrice == 0 ? 'disabled' : '' }}>Thanh toán</button>
                        </form>
                        <!-- Kết thúc form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
