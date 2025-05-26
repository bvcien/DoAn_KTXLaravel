@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Sửa tin tức</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.updateNew', $new->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Tiêu đề: <span>*</span></label>
                <input type="text" id="title" class="form-control mt-2" name="title" value="{{ old('title', $new->title) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Hình ảnh: </label>
                <input type="file" id="image" class="form-control mt-2" name="image" accept="image/*">
                @if ($new->image)
                    <div class="mt-2">
                        <img src="{{ asset('New/' . $new->image) }}" alt="Hình ảnh" width="200">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="content">Nội dung: </label>
                <textarea id="content" class="form-control mt-2" name="content" rows="5">{{ old('content', $new->content) }}</textarea>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.indexNew') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
