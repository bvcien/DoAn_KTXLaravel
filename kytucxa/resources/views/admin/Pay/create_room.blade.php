@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="text-center">Thêm thanh toán theo phòng</h3>

  <div class="card p-4 mt-4">
    <form method="POST" action="{{ route('admin.storePayRoom') }}">
      @csrf

      <div class="form-group mb-3">
        <label for="idRoom">Chọn phòng: *</label>
        <select name="idRoom" id="idRoom" class="form-select" required>
          <option value="">-- Chọn phòng --</option>
          @foreach ($rooms as $room)
            <option value="{{ $room->id }}">{{ $room->name }} ({{ number_format($room->price) }}đ)</option>
          @endforeach
        </select>
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
@endsection
