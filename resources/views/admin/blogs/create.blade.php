@extends('admin.nav')

@section('text')
<style>
    /* Cải thiện kiểu dáng cho form */
.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

/* Tên trường và label */
.form-group label {
    font-size: 16px;
    color: #333;
    font-weight: 500;
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

/* Thêm hiệu ứng hover cho trường nhập liệu */
.form-control:hover {
    border-color: #007bff;
}

/* Khu vực thông báo lỗi */
.alert-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

/* Nút lưu Blog */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

/* Cải thiện kiểu dáng cho trường textarea */
textarea.form-control {
    height: 150px;
}

/* Thêm margin cho các trường form */
.form-group {
    margin-bottom: 20px;
}

</style>
<div class="container mt-4 form-container">
    <h1 style="color: black; padding: 20px; text-align: center;">Thêm Blog</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <!-- Ẩn trường user_id vì nó đã được gán trong controller -->
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <button type="submit" class="btn btn-primary">Lưu Blog</button>
    </form>
</div>
@endsection
