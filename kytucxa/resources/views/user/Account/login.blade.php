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
                    <span>Đăng nhập</span>
                </a>
            </div>
            <div class="login_box-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="pwd" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Nhập mật khẩu" name="password">
                    </div>
                    <div class="login_box-body-login mb-5">
                        <button type="submit">LOGIN</button>
                        <a href="{{ route('user.register') }}">SIGNUP</a>
                    </div>
                </form>
    
                <p>Quên mật khẩu? <a href="{{ route('user.forgot_pwd') }}">Tại đây!</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
