@extends('home.index')
@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>

<section id="page-header">
    <h2>#stayhome</h2>
    <p>Save more with coupons & up to 70% off!</p>
</section>

@php
    $sort = $sort ?? 'nosort';
@endphp

<div class="formCN-container">
    <!-- Cột form: Lọc và tìm kiếm -->
    <div class="form-column">
        <form method="GET" action="{{ route('shop.filter') }}" id="filterForm" class="formTX">
            <h3>Thể loại sản phẩm</h3>
            @foreach($categories as $category)
                <div>
                    <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                        {{ in_array($category->category_id, request('categories', [])) ? 'checked' : '' }}>
                    <label>{{ $category->category_name }}</label>
                </div>
            @endforeach

            <h3>Sắp xếp theo giá</h3>
            <select name="sort" onchange="document.getElementById('filterForm').submit()">
                <option value="nosort">Sắp xếp giá</option>
                <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
            </select>
        </form>
        <h3>Tìm kiếm sản phẩm</h3>
        <form role="search" class="searchShop" action="{{ route('home.search') }}">
            <input type="text" placeholder="Search..." class="form-control" id="search" name="search">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- Cột sản phẩm -->
    <div class="product-column">
        <section id="product1" class="section-p1">
        @if(isset($searchTerm))
        <h2 class="search-result-message">Kết quả tìm kiếm cho: "{{ $searchTerm }}"</h2>
        @endif
        <!-- Hiển thị thông báo nếu không tìm thấy sản phẩm nào -->
        @if(session('message'))
            <p class="alert alert-warning">{{ session('message') }}</p>
        @endif
            <div class="pro-container">
                @foreach ($products as $product)
                    <div class="pro">
                        <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}"
                            onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';" />
                        <div class="des">
                            <span>{{ $product->category->category_name ?? 'Không có thể loại' }}</span>
                            <h5>{{ $product->product_name }}</h5>
                            <div class="star">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $product->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <h4>Số Lượng: {{ $product->quantity }}PCS</h4>
                            <h4>{{ $product->price }}VND</h4>
                        </div>
                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            @if (auth()->check())
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @endif
                            <button type="submit" class="cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="custom-pagination">
                {{ $products->appends(['sort' => $sort])->links() }}
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="categories[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });
});
</script>
@endsection
