<link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <h1>Danh sách sản phẩm</h1>
    {{-- Kiểm tra xem có thông điệp trong session không --}}
    @if (session('message'))
        <div class="alert alert-warning">{{ session('message') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <button class="toggle-button" id="toggleFormButton">Thêm sản phẩm</button> <!-- Nút để mở form -->
    
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
                <label for="image2">Hình ảnh 3:</label>
                <input type="file" id="image3" name="image3" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit">Thêm sản phẩm</button>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thể loại</th>
                <th>Màu sắc</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->category_name ?? 'Không có thể loại' }}</td>
                    <td>{{ $product->color->name ?? 'Không có màu sắc' }}</td>    
                    <td class="product-images">
                        @if ($product->image1)
                            <img src="{{ asset('images/products/' . $product->image1) }}" alt="Hình ảnh 1">
                        @endif
                        @if ($product->image2)
                            <img src="{{ asset('images/products/' . $product->image2) }}" alt="Hình ảnh 2">
                        @endif
                        @if ($product->image3)
                            <img src="{{ asset('images/products/' . $product->image3) }}" alt="Hình ảnh 3">
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                        <a href="{{ route('products.edit', $product->product_id) }}">Cập nhật</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // JavaScript để điều khiển hiển thị form
        document.getElementById('toggleFormButton').addEventListener('click', function() {
            var formContainer = document.getElementById('productForm');
            formContainer.classList.toggle('show');
        });
    </script>
