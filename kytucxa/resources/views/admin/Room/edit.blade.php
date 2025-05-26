@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Sửa phòng KTX</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updateRoom', $room->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="idCategory">Danh mục: <span>*</span></label>
                <select class="form-select mt-3" name="idCategory" required>
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $room->idCategory == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="name">Phòng: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ $room->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="quantity">Số lượng: <span>*</span></label>
                <input type="number" id="quantity" class="form-control mt-2" name="quantity" value="{{ $room->quantity }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image">
                @if($room->image)
                    <img src="{{ asset('Room/' . $room->image) }}" class="mt-2" alt="" width="100">
                @else
                    <p>Chưa có hình ảnh</p>
                @endif
            </div>
            <div class="form-group mb-3">
                <label for="price">Giá tiền / Tháng: <span>*</span></label>
                <input type="number" id="price" class="form-control mt-2" name="price" value="{{ number_format($room->price, 0, ',', '.') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Mô tả: <span>*</span></label>
                <input type="text" id="description" class="form-control mt-2" name="description" value="{{ $room->description }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>Ngừng hoạt động</option>
                    <option value="2" {{ $room->status == 2 ? 'selected' : '' }}>Bảo trì</option>
                </select>
            </div>

            {{-- Thêm trường chọn type --}}
            <div class="form-group mb-3">
                <label for="type">Loại phòng:</label>
                <select class="form-select mt-3" name="type">
                    <option value="">Chọn loại phòng</option>
                    <option value="nam" {{ $room->type == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nữ" {{ $room->type == 'nữ' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexRoom') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection