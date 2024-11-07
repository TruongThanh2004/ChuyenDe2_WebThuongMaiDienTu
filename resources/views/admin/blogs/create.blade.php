@extends('admin.nav')

@section('text')
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">

    <br><h1 style="color: black; padding: 20px; text-align: center;">Thêm Blog</h1> <!-- Đổi màu chữ thành đen để dễ đọc -->


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
