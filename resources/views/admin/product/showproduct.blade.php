@extends('admin.nav')
@section('text')
    <style>
        /* CSS cho trang chi tiết sản phẩm */
        .product-details {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-details h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .product-info p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .product-info strong {
            color: #000;
        }

        /* CSS cho hình ảnh sản phẩm */
        .product-images {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .product-images img {
            width: 300px;
            height: 300px;
            object-fit: cover; /* Giúp hình ảnh cắt vừa đúng khung mà không méo */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease; /* Hiệu ứng khi di chuột qua */
        }

        .product-images img:hover {
            transform: scale(1.05); /* Phóng to hình khi di chuột qua */
        }

        /* CSS cho nút quay lại */
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>

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
