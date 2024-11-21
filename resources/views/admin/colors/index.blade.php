@extends('admin.nav')

@section('text')

<head>
    <!-- CSS colors
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/color/form-list.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

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
                            setTimeout(function () {
                                document.getElementById('success-message').style.display = 'none';
                            }, 3000); 
                        </script>
                    @endif

                    <!-- Thông báo tìm kiếm -->
                    @if (session('notification'))
                        <div class="alert alert-info" role="alert" id="notification">
                            {{ session('notification') }}
                        </div>
                    @endif


                    <!-- Thông báo nếu có kết quả tìm kiếm -->
                    @if (request()->has('keyword') && $colordm->isNotEmpty())
                        <div class="alert alert-info">
                            Đã tìm thấy {{ $colordm->count() }} kết quả cho từ khóa: "{{ request()->input('keyword') }}".
                        </div>
                    @endif

                    <h1 class="title-name">Danh sách bảng màu</h1>
                </div>

                <br>

                <!-- form tìm kiếm -->
                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                    <div class="header-top-menu tabl-d-n hd-search-rp">
                        <div class="breadcome-heading">
                            <form role="search" class="" action="{{ route('admin_colors.timkiemcolors') }}" novalidate>
                                <input type="text" placeholder="Search..." class="form-control" id="search"
                                    name="keyword">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <form action="{{ route('admin_colors.create') }}" method="GET">
                        <button type="submit" class="btn btn-success">Add colors</button>
                    </form>
                </div>

                <div class="sort-list">
                    <form action="{{ route('admin_colors.sortToggle') }}" method="GET">

                        <input type="hidden" name="sort"
                            value="{{ request()->get('sort') === 'asc' ? 'desc' : 'asc' }}">

                        <input type="hidden" name="sort"
                            value="{{ request()->get('sort') === 'asc' ? 'desc' : 'asc' }}">

                        <button type="submit" class="btn btn-success">
                            @if (request()->get('sort') === 'asc')
                                <i class="fas fa-sort-alpha-up"></i> Sắp xếp A → Z
                            @else
                                <i class="fas fa-sort-alpha-down"></i> Sắp xếp Z → A
                            @endif
                        </button>
                    </form>
                </div>

                <table class="table">
                    <thead>
                        @if ($colordm->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                @if(request()->has('keyword'))
                                    Không tìm thấy kết quả cho từ khóa: "{{ request()->input('keyword') }}".
                                    <a href="{{ route('admin_colors.index') }}" class="btn btn-primary btn-sm">Quay lại danh
                                        sách</a>
                                @else
                                    Hiện tại danh sách trống, vui lòng tạo màu mới.
                                    <a href="{{ route('admin_colors.create') }}" class="btn btn-primary btn-sm">Tạo màu mới</a>
                                @endif
                            </div>
                        @else

                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Ảnh</th>
                                        <th>Hành Động</th>
                                        <td class="items-checkbox"><input type="checkbox" id="remove-all" onclick="toggleAll(this)">
                                        </td>
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

                                                <a href="{{ route('admin_colors.edit', ['hashed_id' => $color->hashed_id]) }}"
                                                    class="btn btn-primary btn-sm">Sửa</a>

                                                <form action="{{ route('admin_colors.destroy', ['id' => $color->hashed_id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                                </form>

                                            </td>
                                            <td class="items-checkbox"><input type="checkbox" class="remove-item"
                                                    data-id="{{ $color->color_id }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <form id="delete-selected-form" action="{{ route('admin_colors.deleteSelected') }}" method="POST"
                                class="move-form-right">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_items" id="selected-items">
                                <button type="button" class="btn btn-outline-danger delete-btn" onclick="confirmDeleteAll()">Xóa màu
                                    đã chọn</button>
                                <br>
                                <div class="paginate">
                                    {{ $colordm->links() }}
                                </div>
                        @endif
            </div>
        </div>
    </div>
</div>

<!-- js admin color -->
<script src="{{ asset('js/color/colors-index.js') }}"></script>

@endsection