@extends('blog-admin')

@section('content')
<div class="container mt-4">
    <h1>Chi tiết bài viết</h1>
    <h2>{{ $blog->title }}</h2>
    <p><strong>Tác giả:</strong> {{ $blog->user->name }}</p> <!-- Hiển thị tên người dùng -->
    
    <div class="row">
    <div class="col-md-8">
        <p class="text-justify">{{ $blog->content }}</p> <!-- Căn lề đều bằng Bootstrap -->
    </div>


        <div class="col-md-4">
            @if($blog->image)
                <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh Blog" class="img-fluid">
            @else
                <p>Không có hình ảnh</p>
            @endif
        </div>
    </div>

    <p><strong>Ngày tạo:</strong> {{ $blog->created_at->format('d/m/Y') }}</p> <!-- Hiển thị ngày tạo -->
    
    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>
@endsection
