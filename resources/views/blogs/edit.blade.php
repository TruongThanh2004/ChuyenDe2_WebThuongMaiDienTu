@extends('blog-admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Chỉnh Sửa Blog</h1>
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

    <form action="{{ route('blogs.update', $blog->post_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>

        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $blog->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="user_id">Người dùng</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $blog->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option> <!-- Hiển thị tên đầy đủ của người dùng -->
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($blog->image)
                <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh 1" width="200" height="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Blog</button>
    </form>
</div>
@endsection
