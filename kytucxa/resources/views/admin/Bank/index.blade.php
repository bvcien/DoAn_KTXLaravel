@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchBank') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createBank') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Ngân hàng</th>
                    <th>Số tài khoản</th>
                    <th>Chủ tài khoản</th>
                    <th>Tài khoản</th>
                    <th>Mật khẩu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banks as $bank)
                <tr>
                    <td>{{ $bank->bank }}</td>
                    <td>{{ $bank->stk }}</td>
                    <td>{{ $bank->ctk }}</td>
                    <td>{{ $bank->taikhoan }}</td>
                    <td>{{ str_repeat('*', strlen($bank->matkhau)) }}</td>
                    <td>
                        <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $bank->id }}')">Xóa</a>
                        <a href="{{ route('admin.checkBankApi', $bank->id) }}" class="">Kiểm tra</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa ngân hàng này không?
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
        form.action = "{{ route('admin.deleteBank', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection