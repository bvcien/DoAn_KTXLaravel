@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Lịch sử giao dịch Ngân hàng {{ $bank->bank }} - STK: {{ $bank->stk }}</h2>

    <a href="{{ route('admin.indexBank') }}" class="btn btn-secondary mt-3">Quay lại danh sách ngân hàng</a>
    
    <div class="mt-3">
        @if (isset($jsonData) && isset($jsonData['TranList']) && is_array($jsonData['TranList']) && count($jsonData['TranList']) > 0)
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Thời gian giao dịch</th>
                        <th>Số tài khoản</th>
                        <th>Loại giao dịch</th>
                        <th>Số tiền</th>
                        <th>Nội dung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jsonData['TranList'] as $transaction)
                        <tr>
                            <td>{{ $transaction['transactionDate'] }}</td>
                            <td>{{ $transaction['accountNo'] }}</td>
                            <td>
                                @if ($transaction['creditAmount'] > 0)
                                    <span class="text-success">Nhận tiền</span>
                                @elseif ($transaction['debitAmount'] > 0)
                                    <span class="text-danger">Rút tiền</span>
                                @else
                                    Khác
                                @endif
                            </td>
                            <td>
                                @if ($transaction['creditAmount'] > 0)
                                    <span class="text-success">+{{ number_format($transaction['creditAmount']) }} VND</span>
                                @elseif ($transaction['debitAmount'] > 0)
                                    <span class="text-danger">-{{ number_format($transaction['debitAmount']) }} VND</span>
                                @else
                                    {{ number_format(0) }} VND
                                @endif
                            </td>
                            <td>{{ $transaction['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif (isset($jsonData) && isset($jsonData['error']))
            <div class="alert alert-danger">{{ $jsonData['error'] }}</div>
        @else
            <p>Không có dữ liệu giao dịch.</p>
        @endif
    </div>

    
</div>
@endsection