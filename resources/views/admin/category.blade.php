@extends('admin.nav')
@section('text')

<!-- Mobile Menu end -->
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="icon nalika-user"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Category List</h2>
                                    <p>Welcome <span class="bread-ntd">Admin Template</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="breadcomb-report">
                                <button data-toggle="tooltip" data-placement="left" title="Download Report"
                                    class="btn"><i class="icon nalika-download"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                    <div class="header-top-menu tabl-d-n hd-search-rp">
                        <div class="breadcome-heading">
                            <form role="search" action="" method="GET">
                                <input type="text" placeholder="Search..." class="form-control" id="search"
                                    name="keyword" value="{{ request('keyword') }}">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-status-wrap">
                    <h4>Category List</h4>
                    <div class="add-product">
                        <a href="{{ route('category-list.create') }}">Add New Category</a>
                    </div>

                    <!-- Hiển thị thông báo thành công và lỗi -->
                    @if (session('success'))
                        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
                    @endif
                    <!-- @if (session('error'))
                        <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
                    @endif -->

                    <!-- Kiểm tra danh sách danh mục -->
                    @if ($category->isEmpty())
                        <p style="color: red; font-size: 20px; font-weight: bold;">Không có danh mục nào để hiển thị.</p>
                    @else
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($category as $data_category)
                                <tr>
                                    <td>{{ $data_category->category_id }}</td>
                                    <td>{{ $data_category->category_name }}</td>
                                    <td>
                                        <form action="{{ route('category-list.edit', $data_category->category_id) }}">
                                            <button data-toggle="tooltip" title="Edit" class="pd-setting-ed">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('category-list.destroy', $data_category->category_id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có muốn xóa danh mục này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button data-toggle="tooltip" title="Delete" class="pd-setting-ed">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- Phân trang -->
                        <div class="custom-pagination">
                            {{ $category->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
