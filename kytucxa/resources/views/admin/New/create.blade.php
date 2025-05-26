@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm tin tức mới</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeNew') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Tiêu đề: <span>*</span></label>
                <input type="text" id="title" class="form-control mt-2" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image" accept="image/*">
            </div>

            <div class="form-group mb-3">
                <label for="content">Nội dung: </label>
                <textarea id="content" class="form-control mt-2" name="content" rows="5"></textarea>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexNew') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
