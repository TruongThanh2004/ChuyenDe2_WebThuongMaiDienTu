@extends('admin.nav')

@section('text')
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <br><h1 style="color: black; padding: 20px; text-align: center;">Chi tiết Blog</h1> <!-- Đổi màu chữ thành đen để dễ đọc -->

    <h2>{{ $blog->title }}</h2>
    <p><strong>ID tác giả:</strong> {{ $blog->user_id }}</p>
    <p><strong>Tên tác giả:</strong> {{ $blog->user ? $blog->user->username : 'Không có người dùng' }}</p>
 <!-- Hiển thị tên người dùng -->
    
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
