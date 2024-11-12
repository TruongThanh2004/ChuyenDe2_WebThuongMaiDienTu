@extends('admin.nav')
@section('text')
<link rel="stylesheet" href="{{ asset('css/showproduct.css') }}">

    <div class="product-details">
        <h2>Chi tiết sản phẩm</h2>
        <div class="product-info">
            <p><strong>Tên sản phẩm:</strong> {{ $product->product_name }}</p>
            <p><strong>Mô tả:</strong> {{ $product->description }}</p>
            <p><strong>Giá:</strong> {{ $product->price }} VND</p>
            <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
            <p><strong>Thể loại:</strong> {{ $product->category->category_name ?? 'Không có thể loại' }}</p>
            <p><strong>Màu sắc:</strong> {{ $product->color->name ?? 'Không có màu sắc' }}</p>
            <p><strong>Đánh giá:</strong> {{ $product->rating ?? 'Không có màu sắc' }}</p>
            <!-- Hiển thị các hình ảnh sản phẩm -->
            <div class="product-images">
                @if ($product->image1)
                    <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}" />
                @endif
                @if ($product->image2)
                    <img src="{{ asset('images/products/' . $product->image2) }}" alt="{{ $product->product_name }}" />
                @endif
                @if ($product->image3)
                    <img src="{{ asset('images/products/' . $product->image3) }}" alt="{{ $product->product_name }}" />
                @endif
            </div>
        </div>
        <a href="{{ route('admin.products') }}" class="btn-back">Quay lại danh sách sản phẩm</a>
    </div>
@endsection
