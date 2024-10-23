@extends('admin.nav')

@section('text')
<div class="container" style="background-color: blanchedalmond;">
    <div class="row" style="margin:20px;">
        <div class="col-12">

            <div class="card">
                <div class="card-body">


                    <!-- Thông báo cập nhật thành công -->
                    @if (session('success'))
                        <div class="alert alert-success" role="alert" id="success-message">
                            {{ session('success') }}
                        </div>
                        <script>
                            // Tự động ẩn thông báo sau 5 giây
                            setTimeout(function () {
                                document.getElementById('success-message').style.display = 'none';
                            }, 3000); 
                        </script>
                    @endif


                    <br /><br />
                    <div class="table-responsive">
                        <form action="{{ route('admin_colors.create') }}" method="GET">
                            <button type="submit" class="btn btn-success">Add colors</button>
                        </form>
                    </div>

                </div>
                <br>
                <br>
                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                    <div class="header-top-menu tabl-d-n hd-search-rp">
                        <div class="breadcome-heading">
                            <form role="search" class="" action="{{ route('admin_colors.timkiemcolors') }}">
                                <input type="text" placeholder="Search..." class="form-control" id="search"
                                    name="keyword">
                                <button type="sumbit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <h1>Danh sách bảng màu</h1>

                        <!--  form tim kiếm -->
                        <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                            <div class="header-top-menu tabl-d-n hd-search-rp">
                                <div class="breadcome-heading">


                                </div>
                            </div>

                            @if ($colordm->isEmpty())
                                <div class="alert alert-warning" role="alert">
                                    @if(request()->has('keyword'))
                                        Không tìm thấy kết quả cho từ khóa : "{{ request()->input('keyword') }}".
                                        <a href="{{ route('admin_colors.index') }}" class="btn btn-primary btn-sm">Quay lại danh
                                            sách</a>
                                    @else
                                        Hiện tại danh sách trống, vui lòng tạo màu mới.
                                        <a href="{{ route('admin_colors.create') }}" class="btn btn-primary btn-sm">Tạo màu
                                            mới</a>
                                    @endif
                                </div>
                            @else
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên</th>
                                                <th>Ảnh</th>
                                                <th>Hành Động</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($colordm as $color)
                                            <tr>
                                                <td>{{ $color->color_id }}</td>
                                                <td>{{ $color->name }}</td>

                                                <td>
                                                    @if($color->images)
                                                        <img src="{{ asset('images/colors/' . $color->images) }}" width="70" height="100"
                                                            alt="Color Image">
                                                    @else
                                                        <img src="{{ asset('images/colors/default.png') }}" width="70" height="100"
                                                            alt="Default Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin_colors.edit', $color->color_id) }}"
                                                        class="btn btn-primary btn-sm">Sửa</a>

                                                    <form action="{{ route('admin_colors.destroy', $color->color_id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $colordm->links() }}
                            @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection