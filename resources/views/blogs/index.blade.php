@extends('blog-admin') <!-- Đảm bảo rằng bạn đang sử dụng đúng tên file layout -->

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Danh sách Blog</h1>
        
        <form action="{{ route('blogs.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm blog" value="{{ isset($search) ? $search : '' }}">
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </div>
        </form>

        <!-- Nút Thêm Blog -->
        <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Thêm Blog</a>

        @if($blogs->isEmpty()) <!-- Kiểm tra nếu không có blog -->
            <div class="alert alert-warning" role="alert">
                Không có Blog nào để hiển thị.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $blog->post_id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->content }}</td>
                            <td>
                                @if($blog->image)
                                    <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh 1" width="200" height="150">
                                @else
                                    Không có hình ảnh
                                @endif
                            </td>
                            <td>
                                <!-- Nút Sửa -->
                                <a href="{{ route('blogs.edit', $blog->post_id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                
                                <!-- Nút Xóa -->
                                <form action="{{ route('blogs.destroy', $blog->post_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</button>
                                </form>
                                <!-- Nút Xem Chi Tiết -->
                                <a href="{{ route('blogs.show', $blog->post_id) }}" class="btn btn-info btn-sm">Xem Chi Tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $blogs->appends(['search' => $search])->links('pagination::bootstrap-4') }} <!-- Sử dụng phân trang Bootstrap -->
            </div>
        @endif
    </div>
@endsection
