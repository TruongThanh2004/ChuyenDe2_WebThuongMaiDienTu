@extends('blog-admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Thêm Blog</h1>

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
        <div class="form-group">
            <label for="user_id">Người dùng</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option> <!-- Hiển thị tên đầy đủ của người dùng -->
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Blog</button>
    </form>
</div>
@endsection

