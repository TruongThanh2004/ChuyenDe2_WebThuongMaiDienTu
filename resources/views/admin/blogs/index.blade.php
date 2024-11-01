@extends('admin.nav') <!-- Đảm bảo rằng bạn đang sử dụng đúng tên file layout -->
@section('text')
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <br><h1 style="color: black; padding: 20px; text-align: center;"> Blog</h1> <!-- Đổi màu chữ thành đen để dễ đọc -->

        <!-- Hiển thị thông báo thành công nếu có -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('blogs.index') }}" method="GET" class="form-inline mb-3">
            <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm blog" value="{{ old('search', $search ?? '') }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>

            <!-- Hiển thị thông báo lỗi nếu có -->
            @if ($errors->has('search'))
                <div class="text-danger mt-2">{{ $errors->first('search') }}</div>
            @endif
        </form>

        <!-- Hiển thị message nếu không tìm thấy blog -->
        @if(session('message'))
            <div class="alert alert-warning">{{ session('message') }}</div>
        @endif

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
                        <th style="color: black;">ID</th>
                        <th style="color: black;">Tiêu đề</th>
                        <th style="color: black;">Nội dung</th>
                        <th style="color: black;">Hình ảnh</th>
                        <th style="color: black;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td style="color: black;">{{ $blog->post_id }}</td>
                            <td style="color: black;">{{ $blog->title }}</td>
                            <td style="color: black;">{{ $blog->content }}</td>
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
