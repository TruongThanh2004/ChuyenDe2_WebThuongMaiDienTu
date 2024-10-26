@extends('admin.nav')

@section('text')
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 8px;">
    <!-- Hiển thị thông báo lỗi nếu có -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Hiển thị thông báo thành công nếu có -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <br><h1 style="color: black; padding: 20px; text-align: center;">Chỉnh Sửa Blog</h1> <!-- Đổi màu chữ thành đen để dễ đọc -->

    <form action="{{ route('blogs.update', $blog->post_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" style="color: black;">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>

        <div class="form-group">
            <label for="content" style="color: black;">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $blog->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="image" style="color: black;">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($blog->image)
                <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh 1" width="200" height="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Blog</button>
    </form>
</div>
@endsection
