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
                    <span>Quên mật khẩu</span>
                </a>
            </div>
            <div class="login_box-body">
                <form action="{{ route('user.sendResetPassword') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span>*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tel">Số điện thoại: <span>*</span></label>
                        <input type="text" class="form-control" name="tel" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="login_box-body-login mb-5">
                        <button type="submit">Gửi yêu cầu!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection