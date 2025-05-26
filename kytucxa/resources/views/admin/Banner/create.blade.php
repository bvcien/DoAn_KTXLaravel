@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm Banner</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeBanner') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên Banner: <span>*</span></label>
                <input type="text" id="name" class="form-control mt-2" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image">
            </div>

            <div class="form-group mb-3">
                <label for="type">Thể loại: <span>*</span></label>
                <select class="form-select mt-3" name="type" required>
                    <option value="0">Banner chính</option>
                    <option value="1">Banner phụ (trên)</option>
                    <option value="2">Banner phụ (Dưới)</option>
                </select>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexBanner') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
