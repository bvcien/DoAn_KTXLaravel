@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm danh mục</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeCategory') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên danh mục: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="image">Hình ảnh: (Định dạng: jpeg, png, jpg, gif, svg)</label>
                <input type="file" id="image" class="form-control mt-2" name="image">
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ: <span>*</span></label>
                <input type="text" id="address" class="form-control mt-2" name="address" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Mô tả: <span>*</span></label>
                <input type="text" id="description" class="form-control mt-2" name="description" required>
            </div>
            
            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexCategory') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
