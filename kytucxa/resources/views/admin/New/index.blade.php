@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchNew') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin danh mục cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createNew') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Title</th>
                    <th>Hình ảnh</th>
                    <th>Nội dung</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $new)
                <tr>
                    <td>{{ $new->user ? $new->user->name : 'Không xác định' }}</td>
                    <td>{{ $new->user ? $new->user->email : 'Không xác định' }}</td>
                    <td>{{ $new->title }}</td>
                    <td>
                        @if($new->image)
                            <img src="{{ asset('New/' . $new->image) }}" alt="Hình ảnh" width="60">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <p class="mb-0">{{ $new->content }}</p>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $new->id }}')">Xóa</a>
                        <a href="{{ route('admin.editNew', $new->id) }}" class="">Sửa</a>
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
                Bạn có chắc chắn muốn xóa tin tức này không?
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
        form.action = "{{ route('admin.deleteNew', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection
