@extends('home.index') <!-- Hoặc layout mà bạn đang sử dụng cho trang home -->
@section('content')
<style>
    /* Tối ưu giao diện tiêu đề blog */
h1 {
    margin-top: -20px !important;
}

.blog-img {
    margin-top: 30px;
}

.blog-details h4 a {
    font-size: 50px !important;
}

.custom-pagination {
    margin: 20px auto;
    text-align: center;
    width: 100%;
}

.custom-pagination ul {
    justify-content: center;
}

/* Cải thiện giao diện tìm kiếm và lọc */
.search-filter-wrapper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    align-items: center;
    width: 100%;
}

.search-form {
    flex: 1;
    display: flex;
    justify-content: flex-start;
}

.search-form .form-group {
    margin-right: 10px;
}

.search-form .form-control {
    padding: 15px;
    font-size: 14px;
}

.search-form button {
    padding: 10px 15px;
    font-size: 14px;
}

/* Phần lọc bên phải */
.filter-form {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.filter-form .form-group {
    margin-right: 15px;
}

.filter-form .form-control {
    padding: 10px;
    font-size: 14px;
}

.filter-form button {
    padding: 10px 15px;
    font-size: 14px;
}

/* Nút tất cả bài viết */
.filter-form a {
    padding: 10px 15px;
    font-size: 14px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
}

.filter-form a:hover {
    background-color: #5a6268;
}

/* CSS cho trái tim yêu thích */
.heart-icon {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.3s;
}

.heart-icon.liked {
    color: #e74c3c; /* Màu đỏ khi yêu thích */
}

.favorite-link {
    font-size: 16px;
    display: inline-block;
    text-decoration: none;
    color: #e74c3c;
    margin-left: 20px; /* Khoảng cách giữa nút tìm kiếm và yêu thích */
    align-self: center; /* Căn giữa với các phần tử khác */
}

.favorite-link:hover {
    text-decoration: underline;
}
.blog-box {
    border: 2px solid #ddd;  
    border-radius: 8px;      
    padding: 15px;           
    margin-bottom: 100px;     
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
}

.blog-box:hover {
    border-color: #007bff;  
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); /* Tăng bóng đổ khi hover */
}

</style>

<head>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<section id="page-header" class="blog-header">
    <h2>#readmore</h2>
    <p>Read all case studies about our products!</p>
</section>

<!-- Bố cục tìm kiếm bên trái và lọc bên phải -->
<div class="search-filter-wrapper">
    <!-- Form tìm kiếm bên trái -->
    <form action="{{ route('home.blog') }}" method="GET" class="search-form">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm blog..." value="{{ request('search') }}">
        </div>
        <button type="submit" name="action" value="search" class="btn btn-primary">Tìm kiếm</button>
    </form>

    <!-- Form lọc bên phải -->
    <div class="filter-form">
        <form action="{{ route('home.blog') }}" method="GET" class="form-inline">
            <!-- Lọc theo ngày tháng -->
            <div class="form-group">
                <label for="from_date">Từ ngày:</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="form-group">
                <label for="to_date">Đến ngày:</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <!-- Sắp xếp -->
            <div class="form-group">
                <label for="sort">Sắp xếp:</label>
                <select name="sort" class="form-control">
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>
            </div>

            <button type="submit" name="action" value="filter" class="btn btn-success">Lọc</button>
            <a href="{{ route('home.blog') }}" class="btn btn-secondary">Tất cả bài viết</a>
        </form>
    </div>
</div>

<!-- Liên kết đến trang yêu thích -->
<div class="favorite-link">
    <a href="{{ route('home.favorite') }}">Xem bài viết yêu thích</a>
</div>
<section id="blog">
    <div class="container">
        @if($blogs->isEmpty())
            <div class="alert alert-warning" role="alert">
                Không có Blog nào để hiển thị.
            </div>
        @else
            @foreach($blogs as $blog)
                <div class="blog-box">
                    <div class="blog-img">
                    <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh blog">
                    </div>
                    <div class="blog-details">
                        <h4><a href="{{ route('home.showbl', $blog->post_id) }}">{{ $blog->title }}</a></h4>
                        <p>{{ Str::limit($blog->content, 50) }}</p>
                        <!-- Icon yêu thích -->
                        <span 
                        class="heart-icon {{ is_array(session('favorite_posts', [])) && in_array($blog->post_id, session('favorite_posts', [])) ? 'liked' : '' }}"
                        onclick="toggleFavorite({{ $blog->post_id }})">
                            <i class="fas fa-heart"></i>
                        </span>
                    </div>
                    <h1>{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</h1>
                </div>
            @endforeach
        @endif
    </div>

    <div class="custom-pagination text-center">
        {{ $blogs->links() }}
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</section>
@endsection
<script>
    // Hàm để thêm/xóa bài viết yêu thích vào session
    function toggleFavorite(postId) {
        // Lấy danh sách bài viết yêu thích từ session, đảm bảo là một mảng
        let favoritePosts = @json(session('favorite_posts', [])); // Lấy dữ liệu từ session

        // Kiểm tra nếu favoritePosts không phải là mảng, khởi tạo nó là mảng trống
        if (!Array.isArray(favoritePosts)) {
            favoritePosts = [];
        }

        // Kiểm tra nếu bài viết đã có trong danh sách yêu thích
        if (favoritePosts.includes(postId)) {
            // Nếu có, xóa nó ra khỏi danh sách
            favoritePosts = favoritePosts.filter(id => id !== postId);
        } else {
            // Nếu không, thêm bài viết vào danh sách yêu thích
            favoritePosts.push(postId);
        }

        // Gửi danh sách bài viết yêu thích lên server qua AJAX
        fetch("{{ route('updateFavoritePosts') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ favorite_posts: favoritePosts })
        })
        .then(response => response.json())
        .then(data => {
            // Cập nhật lại giao diện (thay đổi màu trái tim)
            document.location.reload();
        })
        .catch(error => console.error("Error:", error));
    }
</script>

