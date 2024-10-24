@extends('admin.nav')
@section('text')
<head>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
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
                                    <h2>Update Product</h2>
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

<div class="form-container" id="productForm"> 
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
        </div>        
        <div class="form-group">
            <label for="category_id">Thể loại:</label>
            <select id="category_id" name="category_id" required>
                <option value="">Chọn thể loại</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" {{ $category->category_id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="color_id">Màu sắc:</label>
            <select id="color_id" name="color_id" required>
                <option value="">Chọn màu sắc</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->color_id }}" {{ $color->color_id == $product->color_id ? 'selected' : '' }}>
                        {{ $color->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Hình ảnh hiện tại 1:</label><br>
            @if($product->image1)
                <img src="{{ asset('/images/products/' . $product->image1) }}" alt="Image 1" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <input type="file" name="image1" accept="image/*">
        </div>
        <div class="form-group">
            <label>Hình ảnh hiện tại 2:</label><br>
            @if($product->image2)
                <img src="{{ asset('/images/products/' . $product->image2) }}" alt="Image 2" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <input type="file" name="image2" accept="image/*">
        </div>
        <div class="form-group">
            <label>Hình ảnh hiện tại 3:</label><br>
            @if($product->image3)
                <img src="{{ asset('/images/products/' . $product->image3) }}" alt="Image 3" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <input type="file" name="image3" accept="image/*">
        </div>
        <div class="form-group">
            <label for="rating">Đánh giá:</label>
            <input type="number" id="rating" name="rating" min="0" max="5" value="{{ old('rating', $product->rating) }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-ctl-bt waves-effect waves-light">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>

@endsection
