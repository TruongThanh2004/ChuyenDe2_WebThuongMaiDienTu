@extends('admin.nav')

@section('text')
<style>
    /* Cải thiện kiểu dáng cho form chỉnh sửa Blog */
.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

/* Thông báo lỗi và thành công */
.alert {
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #dc3545;
    color: white;
}

.alert-success {
    background-color: #28a745;
    color: white;
}

/* Nút "Cập nhật Blog" */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

/* Trường nhập liệu */
.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 16px;
    width: 100%;
    margin-top: 5px;
}

.form-control:hover {
    border-color: #007bff;
}

/* Cải thiện kiểu dáng cho trường textarea */
textarea.form-control {
    height: 150px;
}

/* Hình ảnh đại diện */
img {
    margin-top: 10px;
    border-radius: 8px;
}

/* Thêm margin cho các trường form */
.form-group {
    margin-bottom: 20px;
}

</style>
<div class="container mt-4 form-container">
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

    <h1 style="color: black; padding: 20px; text-align: center;">Chỉnh Sửa Blog</h1>

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
                <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh Blog" width="200" height="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Blog</button>
    </form>
</div>
@endsection
