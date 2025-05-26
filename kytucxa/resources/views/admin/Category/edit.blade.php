@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Chỉnh sửa danh mục</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updateCategory', $category->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên danh mục: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ $category->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Hình ảnh hiện tại:</label><br>
                @if($category->image)
                    <img src="{{ asset('Category/' . $category->image) }}" alt="Category Image" width="100">
                @else
                    <p>Chưa có hình ảnh</p>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="image">Chọn ảnh mới (nếu cần thay đổi):</label>
                <input type="file" id="image" class="form-control mt-2" name="image">
            </div>

            <div class="form-group mb-3">
                <label for="address">Địa chỉ: <span>*</span></label>
                <input type="text" id="address" class="form-control mt-2" name="address" value="{{ $category->address }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô tả: <span>*</span></label>
                <input type="text" id="description" class="form-control mt-2" name="description" value="{{ $category->description }}" required>
            </div>
            
            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexCategory') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection