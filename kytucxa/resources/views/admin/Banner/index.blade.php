@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchBanner') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin danh mục cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createBanner') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tên</th>
                    <th>Hình ảnh</th>
                    <th>Loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td>{{ $banner->name }}</td>
                    <td>
                        @if($banner->image)
                            <img src="{{ asset('Banner/' . $banner->image) }}" alt="Hình ảnh" width="120">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>
                        @if($banner->type == 0)
                            Banner chính
                        @elseif($banner->type == 1)
                            Banner phụ (trên)
                        @else
                            Banner phụ (dưới)
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $banner->id }}')">Xóa</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Không có banner nào.</td>
                </tr>
                @endforelse
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
                Bạn có chắc chắn muốn xóa banner này không?
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
        form.action = "{{ route('admin.deleteBanner', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection
