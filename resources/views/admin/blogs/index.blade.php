@extends('admin.nav')

@section('text')
    <div class="breadcome-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                        <i class="icon nalika-home"></i>
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2>Danh sách blog</h2>
                                        <p>Chào mừng đến với <span class="bread-ntd">Admin Template</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="breadcomb-report">
                                    <button data-toggle="tooltip" data-placement="left" title="Tải báo cáo" class="btn">
                                        <i class="icon nalika-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        </script>
    @endif

    <!-- Thông báo lỗi -->
    @if (session('error'))
        <div class="alert alert-danger" role="alert" id="error-message">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('error-message').style.display = 'none';
            }, 3000);
        </script>
    @endif

    <div class="product-status mg-b-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                        <div class="header-top-menu tabl-d-n hd-search-rp">
                            <div class="breadcome-heading">
                                <form role="search" class="" action="{{ route('home.blog') }}">
                                    <input type="text" placeholder="Tìm kiếm blog..." class="form-control" id="search" name="search" value="{{ old('search', $search ?? '') }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="product-status-wrap">
                        <h4>Danh sách blog</h4>
                        <div class="add-product">
                            <a href="{{ route('blogs.create') }}">Thêm blog</a>
                        </div>
                        @if($blogs->isEmpty())
                            <p style="color: yellow; font-size: 30px; font-weight: bold;">Không có blog nào để hiển thị.</p>
                        @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                <tr>
                                    <td>
                                        @if($blog->image)
                                            <img src="{{ asset('images/blog/' . $blog->image) }}" alt="{{ $blog->title }}" width="100" height="75">
                                        @else
                                            Không có hình ảnh
                                        @endif
                                    </td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ Str::limit($blog->content, 50) }}</td>
                                    <td>
                                        <a href="{{ route('blogs.show', $blog->post_id) }}" data-toggle="tooltip" title="Xem chi tiết" class="pd-setting-ed">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('blogs.edit', $blog->post_id) }}" data-toggle="tooltip" title="Cập nhật" class="pd-setting-ed">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('blogs.destroy', $blog->post_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-toggle="tooltip" title="Xóa" class="pd-setting-ed">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div class="custom-pagination">
                            {{ $blogs->links() }} <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!confirm('Bạn có chắc chắn muốn xóa?')) {
                event.preventDefault();
            }
        });
    });
});

</script>
