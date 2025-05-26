@extends('layouts.user')

@section('content')
<div class="container pt-4 pb-4">
    <div class="user_titles mb-4">
        <span>
            <a href="{{ route('user.index') }}">Trang chủ</a>
        </span>
        <span>/ Tin tức</span>
    </div>

    <div class="row">
        <!-- Phần bài viết (9 cột) -->
        <div class="col-lg-9">
            <div class="news-detail">
                <h2 class="mb-4 news-title">{{ $news->title }}</h2>
                <p class="mb-4 news-author">
                    Đăng bởi:
                    <strong>
                        <img src="{{ asset('Avatar/' . $news->user->image) }}" 
                            class="user-avatar" 
                            width="36" 
                            height="36"
                            alt="Avatar">
                        {{ $news->user->name }}
                    </strong> - {{ $news->created_at->format('d/m/Y H:i:s') }}
                    
                    <span class="like-buttons">
                        <i class="fa-regular fa-thumbs-up like-btn" data-type="like"></i>
                        <span id="like-count">{{ $news->likes->where('status', 0)->count() }}</span>
                        
                        <i class="fa-regular fa-thumbs-down dislike-btn" data-type="dislike"></i>
                        <span id="dislike-count">{{ $news->likes->where('status', 1)->count() }}</span>
                    </span>
                </p>
                <div class="mb-4 news-image">
                    <img src="{{ asset('New/' . $news->image) }}" class="img-fluid" alt="{{ $news->title }}">
                </div>
                <div class="mb-4 news-content">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>

             <!-- Form bình luận -->
            @auth
            <div class="comment-form mt-3">
                <h5>Viết bình luận</h5>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idNews" value="{{ $news->id }}">
                    <textarea name="content" class="form-control mb-2" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
            @else
                <p class="mt-3">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
            @endauth

            <!-- Danh sách bình luận -->
            <div class="comments mt-4">
                <h5>Bình luận</h5>
                @foreach ($news->comments as $comment)
                    <div class="comment-item mt-3">
                        <strong>{{ $comment->user->name }}</strong> - <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                        <p>{{ $comment->content }}</p>
                        <a href="#" class="reply-btn" data-id="{{ $comment->id }}">Trả lời</a>

                        <!-- Form trả lời -->
                        <form action="{{ route('comments.store') }}" method="POST" class="reply-form d-none" id="reply-form-{{ $comment->id }}">
                            @csrf
                            <input type="hidden" name="idNews" value="{{ $news->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" class="form-control mb-2" rows="2" required></textarea>
                            <button type="submit" class="btn btn-sm btn-success">Gửi</button>
                        </form>

                        <!-- Hiển thị câu trả lời -->
                        @foreach ($comment->replies as $reply)
                            <div class="reply-item">
                                <strong>{{ $reply->user->name }}</strong> - <small>{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                <p>{{ $reply->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Danh sách bài viết khác (3 cột) -->
        <div class="col-lg-3">
            <div class="related-news">
                <h5 class="related-title">Bài viết cùng tác giả</h5>
                @foreach ($relatedNews as $item)
                    <div class="related-item">
                        <a href="{{ route('user.indexTinTuc', $item->id) }}">
                            <img src="{{ asset('New/' . $item->image) }}" class="related-image" alt="{{ $item->title }}">
                            <p class="related-text">{{ $item->title }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const likeBtn = document.querySelector(".like-btn");
        const dislikeBtn = document.querySelector(".dislike-btn");
        const likeCount = document.getElementById("like-count");
        const dislikeCount = document.getElementById("dislike-count");

        function updateButtons(userStatus) {
            likeBtn.classList.remove("active");
            dislikeBtn.classList.remove("active");

            if (userStatus === 0) {
                likeBtn.classList.add("active");
            } else if (userStatus === 1) {
                dislikeBtn.classList.add("active");
            }
        }

        function sendRequest(type) {
            fetch(`/news/{{ $news->id }}/${type}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    likeCount.textContent = data.likes;
                    dislikeCount.textContent = data.dislikes;
                    updateButtons(data.userStatus);
                }
            })
            .catch(error => console.error("Error:", error));
        }

        likeBtn.addEventListener("click", () => sendRequest("like"));
        dislikeBtn.addEventListener("click", () => sendRequest("dislike"));
    });

    document.querySelectorAll(".reply-btn").forEach(btn => {
        btn.addEventListener("click", function(event) {
            event.preventDefault();
            let id = this.getAttribute("data-id");
            document.getElementById("reply-form-" + id).classList.toggle("d-none");
        });
    });
</script>
@endsection
