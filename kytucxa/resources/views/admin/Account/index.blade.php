@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-chucnang mb-3">
        <form action="{{ route('admin.searchAccount') }}" method="GET">
            <div class="admin-search">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="Nhập thông tin tài khoản cần tìm?" value="{{ request('search') }}">
            </div>
        </form>

        <a href="{{ route('admin.createAccount') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="admin-body">
        <div class="card mb-3">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#adminsTable">
                Quản trị viên <i class="fa fa-chevron-down"></i>
            </div>
            <div id="adminsTable" class="collapse">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>MSV</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th>Thông tin</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->msv }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>
                                    @if($admin->image)
                                    <img src="{{ asset('Avatar/' . $admin->image) }}" alt="Hình ảnh" width="60">
                                    @else
                                    Không có ảnh
                                    @endif
                                </td>
                                <td>
                                    <p>Email: {{ $admin->email }}</p>
                                    <p>Tel: {{ $admin->tel }}</p>
                                    <p>Địa chỉ: {{ $admin->address }}</p>
                                    <p>Ngày sinh: {{ \Carbon\Carbon::parse($admin->date)->format('d/m/Y') }}</p>
                                    <p>Trạng thái: {{ $admin->status == 0 ? 'Hoạt động' : 'Ngừng hoạt động' }}</p>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $admin->id }}')">Xóa</a>
                                    <a href="{{ route('admin.editAccount', $admin->id) }}" class="">Sửa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#employeesTable">
                Nhân viên <i class="fa fa-chevron-down"></i>
            </div>
            <div id="employeesTable" class="collapse">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>MSV</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th>Thông tin</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->msv }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>
                                    @if($employee->image)
                                    <img src="{{ asset('Avatar/' . $employee->image) }}" alt="Hình ảnh" width="60">
                                    @else
                                    Không có ảnh
                                    @endif
                                </td>
                                <td>
                                    <p>Email: {{ $employee->email }}</p>
                                    <p>Tel: {{ $employee->tel }}</p>
                                    <p>Địa chỉ: {{ $employee->address }}</p>
                                    <p>Ngày sinh: {{ \Carbon\Carbon::parse($employee->date)->format('d/m/Y') }}</p>
                                    <p>Trạng thái: {{ $employee->status == 0 ? 'Hoạt động' : 'Ngừng hoạt động' }}</p>
                                    <p>Quyền hạn: {{ $employee->competence == 0 ? 'Có quyền' : 'Không quyền' }}</p>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $employee->id }}')">Xóa</a>
                                    <a href="{{ route('admin.editAccount', $employee->id) }}" class="">Sửa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#usersTable">
                Người dùng <i class="fa fa-chevron-down"></i>
            </div>
            <div id="usersTable" class="collapse">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>MSV</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th>Thông tin</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->msv }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if($user->image)
                                    <img src="{{ asset('Avatar/' . $user->image) }}" alt="Hình ảnh" width="60">
                                    @else
                                    Không có ảnh
                                    @endif
                                </td>
                                <td>
                                    <p>Email: {{ $user->email }}</p>
                                    <p>Tel: {{ $user->tel }}</p>
                                    <p>Địa chỉ: {{ $user->address }}</p>
                                    <p>Ngày sinh: {{ \Carbon\Carbon::parse($user->date)->format('d/m/Y') }}</p>
                                    <p>Trạng thái: {{ $user->status == 0 ? 'Hoạt động' : 'Ngừng hoạt động' }}</p>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete('{{ $user->id }}')">Xóa</a>
                                    <a href="{{ route('admin.editAccount', $user->id) }}" class="">Sửa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                Bạn có chắc chắn muốn xóa tài khoản này không?
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
        form.action = "{{ route('admin.deleteAccount', '') }}/" + id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection