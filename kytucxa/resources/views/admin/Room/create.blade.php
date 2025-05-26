@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm phòng KTX</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeRoom') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="idCategory">Danh mục: <span>*</span></label>
                <select class="form-select mt-3" name="idCategory" required>
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="name">Phòng: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="quantity">Số lượng: <span>*</span></label>
                <input type="number" id="quantity" class="form-control mt-2" name="quantity" required>
            </div>
            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image">
            </div>
            <div class="form-group mb-3">
                <label for="price">Giá tiền / Tháng: <span>*</span></label>
                <input type="number" id="price" class="form-control mt-2" name="price" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Mô tả: <span>*</span></label>
                <input type="text" id="description" class="form-control mt-2" name="description" required>
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái: <span>*</span></label>
                <select class="form-select mt-3" name="status" required>
                    <option value="0">Hoạt động</option>
                    <option value="1">Ngừng hoạt động</option>
                    <option value="2">Bảo trì</option>
                </select>
            </div>

            {{-- Thêm trường chọn type --}}
            <div class="form-group mb-3">
                <label for="type">Loại phòng:</label>
                <select class="form-select mt-3" name="type">
                    <option value="">Chọn loại phòng</option>
                    <option value="nam">Nam</option>
                    <option value="nữ">Nữ</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexRoom') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection