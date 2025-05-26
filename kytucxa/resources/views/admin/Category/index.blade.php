@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchCategory') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin danh mục cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createCategory') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tên</th>
                    <th>Hình ảnh</th>
                    <th>Địa chỉ</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('Category/' . $category->image) }}" alt="Hình ảnh" width="60">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>{{ $category->address }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $category->id }}')">Xóa</a>
                        <a href="{{ route('admin.editCategory', $category->id) }}" class="">Sửa</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa danh mục này không?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        let form = document.getElementById('deleteForm');
        form.action = "{{ route('admin.deleteCategory', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection
