<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ký túc xá - Quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('iconTask/icontask.png') }}">

    <!-- css -->
    @vite(['resources/css/app.css'])
    @vite(['resources/css/admin.css'])
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-md-2 admin_sidebar p-2">
                <div class="admin_sidebar-title">
                    <a href="{{ route('admin.index') }}">StartAdmin</a>
                </div>
                <div class="admin_sidebar-body pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexCategory') }}">
                                <i class="fas fa-list-alt"></i> Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexRoom') }}">
                                <i class="fas fa-door-open"></i> Phòng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexMember') }}">
                                <i class="fas fa-users"></i> Thành viên
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexPay') }}">
                                <i class="fa-solid fa-money-check"></i> Tài chính
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexHoaDon') }}">
                                <i class="fa-solid fa-money-check-dollar"></i> Hóa Đơn
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexNew') }}">
                                <i class="fa-solid fa-newspaper"></i> Tin tức
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexBanner') }}">
                                <i class="fa-solid fa-sliders"></i> Tính năng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexBank') }}">
                                <i class="fa-solid fa-building-columns"></i> Ngân hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="admin__sidebar-link" href="{{ route('admin.indexAccount') }}">
                                <i class="fas fa-user-circle"></i> Tài khoản
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

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


            <div class="col-md-10 p-4 overflow-auto content-section">
                @yield('content')
            </div>
        </div>
    </div>



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