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
                                    <i class="icon nalika-user"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Add New Product</h2>
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
    
<div class="form-container" id="productForm"> <!-- Thêm container cho form -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>        
        <div class="form-group">
            <label for="category_id">Thể loại:</label>
            <select id="category_id" name="category_id" required>
                <option value="">Chọn thể loại</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="color_id">Màu sắc:</label>
            <select id="color_id" name="color_id" required>
                <option value="">Chọn màu sắc</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->color_id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image1">Hình ảnh 1:</label>
            <input type="file" id="image1" name="image1" accept="image/*">
        </div>
        <div class="form-group">
            <label for="image2">Hình ảnh 2:</label>
            <input type="file" id="image2" name="image2" accept="image/*">
        </div>
        <div class="form-group">
            <label for="image3">Hình ảnh 3:</label>
            <input type="file" id="image3" name="image3" accept="image/*">
        </div>
        <div class="form-group">
            <button type="submit">Thêm sản phẩm</button>
        </div>
    </form>
</div>

@endsection
