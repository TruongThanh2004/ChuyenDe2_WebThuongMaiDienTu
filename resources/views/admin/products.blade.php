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
                                        <h2>Product List</h2>
                                        <p>Welcome to Nalika <span class="bread-ntd">Admin Template</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="breadcomb-report">
                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn">
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
    </div>

    <!-- Thông báo lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="product-status mg-b-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>Products List</h4>
                        <div class="add-product">
                            <!-- <a href="{{ route('products.create') }}">Add Product</a> -->
                        </div>
                        <table>
                            <tr>
                                <th>Image</th>
                                <th>Product Title</th>
                                <th>Status</th>
                                <th>Purchases</th>
                                <th>Product Sales</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Setting</th>
                            </tr>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}" />
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    @if($product->status == 'active')
                                        <button class="pd-setting">Active</button>
                                    @elseif($product->status == 'paused')
                                        <button class="ps-setting">Paused</button>
                                    @else
                                        <button class="ds-setting">Disabled</button>
                                    @endif
                                </td>
                                <td>{{ $product->purchases }}</td>
                                <td>${{ $product->sales }}</td>
                                <td>{{ $product->stock_status }}</td>
                                <td>${{ $product->price }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->product_id) }}" data-toggle="tooltip" title="Edit" class="pd-setting-ed">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-toggle="tooltip" title="Trash" class="pd-setting-ed">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <div class="custom-pagination">
                            {{ $products->links() }} <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
