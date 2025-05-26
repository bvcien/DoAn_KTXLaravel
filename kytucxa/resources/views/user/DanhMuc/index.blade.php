@extends('layouts.user')

@section('content')
<div class="container pb-4 pt-4">
    <div class="user_titles pt-4 mb-4">
        <span>
            <a href="">Trang chủ</a>
        </span>
        <span>/ {{ $category->name }}</span>
    </div>

    <div class="row">
        <!-- Danh sách phòng -->
        <div class="col-md-9">
            <h4 class="mb-3">Danh sách phòng trong danh mục: {{ $category->name }}</h4>

            @foreach($category->rooms as $room)
            <table class="table table-bordered mb-4">
                <tr>
                    <th style="width: 150px;">Tên phòng</th>
                    <td>{{ $room->name }}</td>
                </tr>
                <tr>
                    <th>Ảnh</th>
                    <td>
                        <img src="{{ asset('Room/' . $room->image) }}" alt="{{ $room->name }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                    </td>
                </tr>
                <tr>
                    <th>Số lượng người / phòng</th>
                    <td>{{ $room->quantity }}</td>
                </tr>
                <tr>
                    <th>Số lượng người ở hiện tại</th>
                    <td>{{ $room->members->count() }}</td>
                </tr>
                <tr>
                    <th>Giá</th>
                    <td>{{ number_format($room->price, 0, ',', '.') }} đ</td>
                </tr>
                <tr>
                    <th>Loại phòng</th>
                    <td>{{ $room->type }}</td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>
                        @if($room->status == 0)
                        <span class="badge bg-success">Hoạt động</span>
                        @elseif($room->status == 1)
                        <span class="badge bg-danger">Ngừng hoạt động</span>
                        @else
                        <span class="badge bg-warning">Bảo trì</span>
                        @endif
                    </td>
                </tr>
            </table>
            @endforeach
        </div>

        <!-- Sidebar bên phải -->
        <div class="col-md-3">
            <h4 class="mb-3">Thông tin danh mục</h4>
            <div class="card mb-4">
                <img src="{{ asset('Category/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text">{{ $category->description }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $category->address }}</p>
                </div>
            </div>

            <h4 class="mb-3">Đăng ký ở KTX</h4>
            <div class="card mb-4">
                <a href="{{ route('user.indexDangKyKTX') }}" class="btn btn-success">Đăng ký</a>
            </div>
        </div>
    </div>
</div>
@endsection