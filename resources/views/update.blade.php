<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<div class="form-container" id="productForm">
    <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Sử dụng PUT vì đây là update -->
        
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

        <!-- Hiển thị ảnh cũ -->
        <div class="form-group">
            <label>Hình ảnh hiện tại:</label><br>
            @if($product->image1)
                <img src="{{ asset('/images/products/' . $product->image1) }}" alt="Image 1" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <label for="image1">Tải lên hình ảnh mới:</label>
            <input type="file" id="image1" name="image1" accept="image/*">
        </div>

        <div class="form-group">
            <label>Hình ảnh hiện tại 2:</label><br>
            @if($product->image2)
                <img src="{{ asset('/images/products/' . $product->image2) }}" alt="Image 2" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <label for="image2">Tải lên hình ảnh mới:</label>
            <input type="file" id="image2" name="image2" accept="image/*">
        </div>

        <div class="form-group">
            <label>Hình ảnh hiện tại 3:</label><br>
            @if($product->image3)
                <img src="{{ asset('/images/products/' . $product->image3) }}" alt="Image 3" width="100">
            @else
                <p>Không có hình ảnh nào</p>
            @endif
            <label for="image3">Tải lên hình ảnh mới:</label>
            <input type="file" id="image3" name="image3" accept="image/*">
        </div>

        <div class="form-group">
            <label for="rating">Điểm đánh giá:</label>
            <input type="number" id="rating" name="rating" min="0" max="5" value="{{ old('rating', $product->rating) }}">
        </div>

        <div class="form-group">
            <button type="submit">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>
