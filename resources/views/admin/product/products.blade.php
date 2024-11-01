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
                                        <h2>Danh sách sản phẩm</h2>
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
   <!-- Thông báo lỗi tìm kiếm -->
                    <!-- @if (session('message'))
                        <div class="alert alert-success" role="alert" id="success-message">
                            {{ session('message') }}
                        </div>
                        <script>
                            // Tự động ẩn thông báo sau 5 giây
                            setTimeout(function () {
                                document.getElementById('success-message').style.display = 'none' style.color = 'white';
                            }, 3000);
                        </script>
                    @endif -->
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

                    @if (session('error'))
                        <div class="alert alert-success" role="alert" id="success-message">
                            {{ session('error') }}
                        </div>
                        <script>
                            // Tự động ẩn thông báo sau 5 giây
                            setTimeout(function () {
                                document.getElementById('success-message').style.display = 'none';
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
                            <form role="search" class="" action="{{ route('admin.products.search') }}">
                                <input type="text" placeholder="Search..." class="form-control" id="search"
                                    name="search">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="product-status-wrap">
                        <h4>Danh sách sản phẩm</h4>
                        <div class="add-product">
                            <a href="{{ route('products.create') }}">Thêm sản phẩm</a>
                        </div>
                        @if($products->isEmpty())
                            <p style="color: yellow; font-size: 30px; font-weight: bold;">Không có sản phẩm nào để hiển thị.</p>
                        @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thể loại</th>
                                    <th>Màu sắc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}" />
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}VND</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->category->category_name ?? 'Không có thể loại' }}</td>
                                    <td>{{ $product->color->name ?? 'Không có màu sắc' }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->product_id) }}" data-toggle="tooltip" title="Xem chi tiết" class="pd-setting-ed">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->product_id) }}" data-toggle="tooltip" title="Cập nhật" class="pd-setting-ed">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-toggle="tooltip" title="Xóa" class="pd-setting-ed">
                                                <i class="fa fa-trash-o"  onclick="return confirm('Bạn có chắc chắn muốn xóa?')" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div class="custom-pagination">
                            {{ $products->links() }} <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
