<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kí túc xá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('iconTask/icontask.png') }}">


    <!-- css -->
    @vite(['resources/css/app.css'])
    @vite(['resources/css/user.css'])
</head>

<body>
    @if (
    Route::currentRouteName() !== ['user.login', 'login','user.register','user.verifyCode', 'user.forgot_pwd']
    && !request()->is('login')
    && !request()->is('register')
    && !request()->is('forgot_pwd')
    && !request()->is('verify-code')
    )
    <header>
        <div class="container d-flex justify-content-between">
            <ul class="nav user_main-header">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <img src="{{ asset('logo/logo_ktx.png ') }}" width="50"> Quản lý kí túc xá
                    </a>
                </li>
            </ul>

            @if(Auth::check())
            <div class="d-flex justify-content-between align-content-center">
                <div class="dropdown home-dropdown">
                    <img data-bs-toggle="dropdown" aria-expanded="false"
                        src="{{ asset('Avatar/' . auth()->user()->image) }}"
                        alt="">
                    <ul class="dropdown-menu dropdown-menu-end mt-4">
                        <li>
                            <a class="dropdown-item" style="pointer-events: none; cursor: default; width: 140px;">
                                <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.billHoaDon') }}">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Hóa đơn
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.indexSetting') }}">
                                <i class="fa-solid fa-gear"></i> Cài đặt
                            </a>
                        </li>
                        @if(auth()->check() && (auth()->user()->role == 0 || auth()->user()->role == 1))
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.index') }}" target="_blank">
                                <i class="fa-solid fa-address-card"></i> Quản lý
                            </a>
                        </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fa-solid fa-outdent"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            @else
            <div class="login_btn">
                <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
            </div>
            @endif
        </div>
    </header>

    <div class="header_sub">
        <div class="container">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">Trang chủ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="">Danh mục</a>
                    <div class="dropdown-menu">
                        <ul class="dropdown-content">
                            @foreach($categories as $category)
                            <li><a href="{{ route('user.indexDanhMuc', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.indexDangKyKTX') }}">Đăng ký KTX</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.indexThanhToan') }}">Thanh toán</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.billHoaDon') }}">Hóa đơn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ: 0369904797</a>
                </li>
            </ul>
        </div>
    </div>
    @endif

    <!-- Thông báo -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Body -->
    <div style="background: #eaeffa;">
        @yield('content')
    </div>

    @if (
    Route::currentRouteName() !== ['user.login', 'login','user.register','user.verifyCode', 'user.forgot_pwd']
    && !request()->is('login')
    && !request()->is('register')
    && !request()->is('forgot_pwd')
    && !request()->is('verify-code')
    )
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="footer-title mb-3">Về chúng tôi</h3>
                    <p>TRƯỜNG ĐẠI HỌC PHƯƠNG ĐÔNG</p>
                    <p>Địa chỉ: <span>4 Ng. Chùa Hưng Ký, Minh Khai, Hai Bà Trưng, Hà Nội</span></p>
                    <p>Tel-1: <span>0912388123</span></p>
                    <p>Tel-2: <span>0912388334</span></p>
                    <p>Thuộc: <span>Bộ giáo dục</span></p>
                </div>
                <div class="col-md-3">
                    <h3 class="footer-title mb-3">Thông tin dự án</h3>
                    <p>Dự án: <span>Tốt nghiệp 2025</span></p>
                    <p>Đề tài: <span>Xây dựng ứng dụng quản lý ký túc xá trên nền web sử dụng công nghệ Laravel
                        </span></p>
                    <p>Mã sinh viên: <span>521100198</span></p>
                    <p>Họ và tên: <span>Bùi Văn Chiến</span></p>
                    <p>Khoa: <span>Công nghệ thông tin</span></p>
                </div>
                <div class="col-md-6">
                    <h3 class="footer-title mb-3">Kết nối với tôi</h3>
                    <p>Email: <span>chienbui19102003@gmail.com</span></p>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="https://www.facebook.com/chienbui2003" target="_blank">
                                <img src="https://static.vecteezy.com/system/resources/thumbnails/018/930/698/small/facebook-logo-facebook-icon-transparent-free-png.png" alt="" class="img-size">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="https://www.instagram.com/cienbui_/" target="_blank">
                                <img src="https://png.pngtree.com/png-clipart/20180518/ourmid/pngtree-instagram-icon-instagram-logo-png-image_3571406.png" alt="" class="img-size">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="https://github.com/bvcien" target="_blank">
                                <img src="https://download.logo.wine/logo/GitHub/GitHub-Logo.wine.png" alt="" class="img-size">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    new bootstrap.Alert(alert).close();
                });
            }, 3000);
        });
    </script>

    <script>
        function checkAndUpdateBills() {
            fetch('/api/check-bills')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Hóa đơn đã được kiểm tra và cập nhật thành công.");
                    } else {
                        console.log("Có lỗi xảy ra khi cập nhật hóa đơn.");
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }

        // Gọi hàm checkAndUpdateBills mỗi 30 giây (30000ms)
        setInterval(checkAndUpdateBills, 15000);
    </script>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>