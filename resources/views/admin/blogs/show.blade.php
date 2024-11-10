@extends('admin.nav')

@section('text')
<style>
    .blog-content {
    white-space: pre-wrap; /* Đảm bảo nội dung xuống dòng đúng khi có newline */
    word-wrap: break-word; /* Cắt từ dài để tránh kéo dài ngang */
    overflow-wrap: break-word; /* Cắt từ dài nếu vượt quá chiều rộng của vùng chứa */
    word-break: break-all; /* Đảm bảo các từ dài cũng được cắt khi cần thiết */
}

</style>
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <br><h1 style="color: black; padding: 20px; text-align: center;">Chi tiết Blog</h1>

    <h2>{{ $blog->title }}</h2>
    <p><strong>ID tác giả:</strong> {{ $blog->user_id }}</p>
    <p><strong>Tên tác giả:</strong> {{ $blog->user ? $blog->user->username : 'Không có người dùng' }}</p>

    <div class="row">
        <div class="col-md-8">
            <div class="blog-content">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>

        <div class="col-md-4">
            @if($blog->image)
                <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh Blog" class="img-fluid" style="border-radius: 8px;">
            @else
                <p>Không có hình ảnh</p>
            @endif
        </div>
    </div>

    <p><strong>Ngày tạo:</strong> {{ $blog->created_at->format('d/m/Y') }}</p>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection
