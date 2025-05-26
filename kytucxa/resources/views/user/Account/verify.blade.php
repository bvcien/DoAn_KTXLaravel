@extends('layouts.user')

@section('content')
<div class="login">
    <div class="login_box">
        <div class="login_box-title">
            <a href="{{ route('user.index') }}">
                <img src="{{ asset('logo/logo_pd.png') }}" alt="" width="80">
            </a>
        </div>
        <div class="login_box-body">
            <form action="{{ route('user.handleVerifyCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Mã xác thực <span>*</span></label>
                    <input type="text" class="form-control" name="code" placeholder="Nhập mã xác thực" required>
                </div>

                @if ($errors->has('code'))
                    <p style="color: red;">{{ $errors->first('code') }}</p>
                @endif

                <div class="login_box-body-login mb-5">
                    <button type="submit">XÁC THỰC</button>
                </div>
            </form>

            <p><a href="{{ route('user.register') }}">Đăng ký lại.</a></p>
        </div>
    </div>
</div>

<script>
    let timeout;
    function checkUserActivity() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetch("{{ route('user.deleteTempAccount') }}", { method: "POST", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }})
                .then(() => window.location.href = "{{ route('user.register') }}");
        }, 50000);
    }

    window.addEventListener("mousemove", checkUserActivity);
    window.addEventListener("keydown", checkUserActivity);
    window.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            checkUserActivity();
        }
    });

    checkUserActivity();
</script>
@endsection