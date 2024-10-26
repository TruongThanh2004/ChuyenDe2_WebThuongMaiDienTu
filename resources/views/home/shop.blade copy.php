@extends('home.index')
@section('content')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('style.css') }}">
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('script.js') }}"></script>
<section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
    </section>
    <form action="{{ route('product.filter') }}" method="GET" class="filter-form">
    <select name="category_id">
        <option value="">Chọn Danh Mục</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>

    <select name="color_id">
        <option value="">Chọn Màu Sắc</option>
        @foreach ($colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
    </select>

    <button type="submit">Lọc</button>
    </form>
    <section id="product1" class="section-p1">
        <div class="pro-container">
        @if($products->isEmpty())
            <p>Không tìm thấy sản phẩm nào</p>
        @else
        @foreach ($products as $product)
        <div class="pro" onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';">
            <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}" />
                <div class="des">
                <span>{{ $product->category->category_name ?? 'Không có thể loại' }}</span>
                <h5>{{ $product->product_name }}</h5>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>{{ $product->price }}VND</h4>
                </div>
                <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
            </div>
            @endforeach      
            @endif    
        </div>
        <div class="custom-pagination">
        {{ $products->links() }}
    </div>
    </section>   
    @endsection