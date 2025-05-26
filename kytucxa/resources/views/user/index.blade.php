@extends('layouts.user')

@section('content')
<div class="container pt-4">
    <!-- Banner -->
    <div class="row">
            <!-- Hiển thị banner có type = 0 -->
            <div class="col-md-9">
                @foreach ($banner_main as $index => $banner)
                        <img class="banner_main w-100 banner-main-item {{ $index > 0 ? 'd-none' : '' }}" 
                            src="{{ asset('Banner/' . $banner->image) }}" 
                            alt="">
                @endforeach
            </div>

            <div class="col-md-3">
                <!-- Hiển thị banner có type = 1 -->
                <div class="banner_sub mb-4">
                    @foreach ($banner_sub_1 as $index => $banner)
                            <img class="w-100 banner-sub1-item {{ $index > 0 ? 'd-none' : '' }}" 
                                src="{{ asset('Banner/' . $banner->image) }}" 
                                alt="">
                    @endforeach
                </div>
                <!-- Hiển thị banner có type = 2 -->
                <div class="banner_sub">
                    @foreach ($banner_sub_2 as $index => $banner)
                            <img class="w-100 banner-sub2-item {{ $index > 0 ? 'd-none' : '' }}" 
                                src="{{ asset('Banner/' . $banner->image) }}" 
                                alt="">
                    @endforeach
                </div>
            </div>
        </div>

    <!-- Tin tức -->
    <div class="home_new mt-5">
        <h3> <i class="fa-solid fa-newspaper"></i> Tin tức mới nhất</h3>
        <div class="row">
            @foreach($news as $new)
            <div class="col-md-4 mt-3 mb-4">
                <div class="cart">
                    <a href="{{ route('user.indexTinTuc', $new->id) }}" class="news-link">
                        <div class="news-overlay">
                            <i class="fas fa-eye"></i>
                            <span>Đọc tin tức</span>
                        </div>
                        <h6 class="new_title">
                            {{ $new->title }}
                        </h6>
                        <img src="{{ asset('New/' . $new->image) }}" alt="Không có ảnh">
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function rotateBanner(className) {
            let banners = document.querySelectorAll("." + className);
            let index = 0;

            setInterval(() => {
                banners[index].classList.add("d-none");
                index = (index + 1) % banners.length;
                banners[index].classList.remove("d-none");
            }, 3000);
        }

        rotateBanner("banner-main-item"); // Chạy banner chính
        rotateBanner("banner-sub1-item"); // Chạy banner phụ 1
        rotateBanner("banner-sub2-item"); // Chạy banner phụ 2
    });
</script>
@endsection