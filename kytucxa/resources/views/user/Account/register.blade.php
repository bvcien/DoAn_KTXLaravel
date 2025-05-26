@extends('layouts.user')

@section('content')
<div class="login">
    <div class="login_box row">
        <div class="col-md-6 login_box-l">
            <img src="{{ asset('Logo/image_login.png') }}" alt="">
        </div>
        <div class="col-md-6 login_box-r">
            <div class="login_box-title">
                <a href="{{ route('user.index') }}">
                    <img src="{{ asset('Logo/logo_ktx.png') }}" alt="" width="80">
                    <span>Đăng ký</span>
                </a>
            </div>
            <div class="login_box-body">
                <form action="{{ route('user.handleRegister') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="msv">Mã sinh viên<span>*</span></label>
                        <input type="text" class="form-control" name="msv" placeholder="Nhập msv" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Mật khẩu <span>*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                        <p><i class="fa-solid fa-circle-check"></i> Mật khẩu lớn hơn 8 kí tự</p>
                        <p><i class="fa-solid fa-circle-check"></i> Mật khẩu có kí tự hoa</p>
                        <p><i class="fa-solid fa-circle-check"></i> Mật khẩu có số</p>
                    </div>

                    <div class="form-group mt-3">
                        <label for="name">Tên: <span>*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="cccd">CCCD: <span>*</span></label>
                        <input type="text" id="cccd" class="form-control mt-2" name="cccd" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="sex">Giới tính: <span>*</span></label>
                        <select class="form-select mt-3" name="sex" required>
                            <option value="0">Nam</option>
                            <option value="1">Nữ</option>
                            <option value="2">Khác</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="date">Ngày sinh: <span>*</span></label>
                        <input type="date" class="form-control" name="date" placeholder="Nhập ngày sinh" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tel">Số điện thoại: <span>*</span></label>
                        <input type="text" class="form-control" name="tel" placeholder="Nhập số điện thoại" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="address">Địa chỉ: <span>*</span></label>
                        <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ" required>
                    </div>

                    <div class="login_box-body-login mb-5">
                        <button type="submit">SIGNUP</button>
                    </div>
                </form>

                <p>Đã có tài khoản! <a href="{{ route('login') }}">Đăng nhập.</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const checkLength = document.querySelector('.form-group p:nth-child(3)');
        const checkUpperCase = document.querySelector('.form-group p:nth-child(4)');
        const checkNumber = document.querySelector('.form-group p:nth-child(5)');

        // Check dữ liệu nhập trong input mật khẩu
        passwordInput.addEventListener("input", function() {
            const password = passwordInput.value;

            // Kiểm tra độ dài mật khẩu
            if (password.length >= 8) {
                checkLength.classList.add("valid");
            } else {
                checkLength.classList.remove("valid");
            }

            // Kiểm tra ký tự hoa
            if (/[A-Z]/.test(password)) {
                checkUpperCase.classList.add("valid");
            } else {
                checkUpperCase.classList.remove("valid");
            }

            // Kiểm tra số
            if (/\d/.test(password)) {
                checkNumber.classList.add("valid");
            } else {
                checkNumber.classList.remove("valid");
            }
        });
    });

    // Loại bỏ khoảng trắng ở Email và mật khẩu
    document.addEventListener("DOMContentLoaded", function() {
        const emailInput = document.querySelector('input[name="email"]');
        const passwordInput = document.querySelector('input[name="password"]');

        function removeSpaces(event) {
            event.target.value = event.target.value.replace(/\s/g, "");
        }

        emailInput.addEventListener("input", removeSpaces);
        passwordInput.addEventListener("input", removeSpaces);
    });
</script>
@endsection