@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm thanh toán theo thành viên</h3>

    <div class="card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storePayMember') }}">
            @csrf

            <div class="form-group mb-3">
                <label>Chọn thành viên: *</label>

                <!-- Nút chọn tất cả -->
                <button type="button" class="btn btn-primary btn-sm mb-2" id="select-all-btn">Chọn tất cả</button>

                <div class="border p-3" style="max-height: 250px; overflow-y: scroll;">
                    @foreach ($members as $member)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="idMember[]" value="{{ $member->id }}" id="member{{ $member->id }}">
                        <label class="form-check-label" for="member{{ $member->id }}">
                            {{ $member->name }} (Phòng: {{ $member->room->name }}, {{ number_format($member->room->price) }}đ)
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Thời gian bắt đầu: *</label>
                <input type="date" name="time_at" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Thời gian kết thúc: *</label>
                <input type="date" name="time_out" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Ghi chú:</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>

            <div class="form_footer">
                <button type="submit" class="btn btn-success">Thêm</button>
                <a href="{{ route('admin.indexPay') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('select-all-btn').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="idMember[]"]');

        var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !allChecked;
        });

        if (allChecked) {
            this.innerHTML = 'Chọn tất cả'; 
        } else {
            this.innerHTML = 'Bỏ chọn tất cả'; 
        }
    });
</script>
@endsection