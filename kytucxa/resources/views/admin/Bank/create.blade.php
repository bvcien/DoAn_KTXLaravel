@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Thêm bank</h3>

    <div class="admin-create card p-4 mt-4">
        <form method="POST" action="{{ route('admin.storeBank') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="bank">Ngân hàng: <span>*</span></label>
                <select name="bank" id="bank" class="form-control mt-2" required>
                    <option value="MBBank">MBBank</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="stk">Số tài khoản: <span>*</span></label>
                <input type="text" id="stk" class="form-control mt-2" name="stk" required>
            </div>

            <div class="form-group mb-3">
                <label for="ctk">Chủ tài khoản: <span>*</span></label>
                <input type="text" id="ctk" class="form-control mt-2" name="ctk" required>
            </div>

            <div class="form-group mb-3">
                <label for="taikhoan">Tài khoản: <span>*</span></label>
                <input type="text" id="taikhoan" class="form-control mt-2" name="taikhoan" required>
            </div>

            <!-- <div class="form-group mb-3">
                <label for="matkhau">Mật khẩu: <span>*</span></label>
                <input type="password" id="matkhau" class="form-control mt-2" name="matkhau" required>
            </div> -->
            <div class="form-group mb-3">
                <label for="matkhau">Mật khẩu: <span>*</span></label>
                <div class="input-group mt-2">
                    <input type="password" id="matkhau" class="form-control" name="matkhau" required>
                    <button type="button" id="toggleBtn" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form_footer mt-4">
                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <a href="{{ route('admin.indexBank') }}" class="btn btn-info">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('matkhau');
        const toggleIcon = document.querySelector('#toggleBtn i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection