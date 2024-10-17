<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f9f9f9; /* Màu nền nhẹ */
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-container {
            max-width: 600px; /* Kích thước tối đa của form */
            background-color: #fff; /* Màu nền của form */
            padding: 20px; /* Padding cho form */
            border-radius: 10px; /* Bo góc cho form */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Đổ bóng cho form */
            margin: 0 auto; /* Căn giữa form */
            overflow: hidden; /* Ẩn các phần thừa ra ngoài */
            height: 0; /* Chiều cao ban đầu của form */
            transition: height 0.5s ease, opacity 0.5s ease; /* Hiệu ứng chuyển động cho chiều cao và opacity */
            opacity: 0; /* Đặt opacity bằng 0 */
        }

        .form-container.show {
            height: auto; /* Đặt chiều cao tự động khi hiển thị */
            opacity: 1; /* Đặt opacity bằng 1 */
        }

        .form-group {
            margin-bottom: 20px; /* Tăng khoảng cách giữa các trường */
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555; /* Màu chữ label */
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            padding: 12px; /* Tăng padding cho các trường */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px; /* Tăng kích thước font */
            transition: border-color 0.3s ease; /* Hiệu ứng chuyển động cho border */
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #007bff; /* Màu border khi focus */
            outline: none; /* Tắt outline mặc định */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Thêm bóng cho trường focus */
        }

        .form-group textarea {
            resize: vertical; /* Cho phép người dùng thay đổi kích thước chiều cao */
            min-height: 100px; /* Chiều cao tối thiểu cho textarea */
        }

        .form-group button {
            padding: 12px; /* Tăng padding cho nút */
            background-color: #007bff; /* Màu xanh dương */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px; /* Tăng kích thước font */
            transition: background-color 0.3s ease; /* Hiệu ứng chuyển động cho background */
        }

        .form-group button:hover {
            background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px; /* Tăng khoảng cách trên bảng */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho bảng */
        }

        th, td {
            padding: 12px; /* Tăng padding để tạo không gian */
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff; /* Màu nền cho th */
            color: white; /* Màu chữ cho th */
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .alert-warning {
            background-color: #ffeeba;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        button {
            color: red;
            border: none;
            background: none;
            cursor: pointer;
        }

        a {
            color: #007bff; /* Màu chữ cho link */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline; /* Gạch chân khi hover */
        }

        /* Hiệu ứng animation cho table */
        tbody tr {
            transition: background-color 0.3s ease; /* Hiệu ứng chuyển động cho hàng */
        }

        tbody tr:hover {
            background-color: #f1f1f1; /* Màu nền khi hover */
        }

        .toggle-button {
            padding: 12px 20px; /* Padding cho nút toggle */
            background-color: #007bff; /* Màu xanh dương */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px; /* Kích thước font */
            transition: background-color 0.3s ease; /* Hiệu ứng chuyển động cho background */
            margin-bottom: 20px; /* Khoảng cách dưới nút toggle */
        }

        .toggle-button:hover {
            background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
        }
    </style>
</head>
<body>

    <h1>Danh sách sản phẩm</h1>

    {{-- Kiểm tra xem có thông điệp trong session không --}}
    @if (session('message'))
        <div class="alert alert-warning">{{ session('message') }}</div>
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
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
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

    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thể loại</th>
                <th>Màu sắc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isEmpty())
                <tr>
                    <td colspan="6" style="text-align: center;">Hiện tại không có sản phẩm nào.</td>
                </tr>
            @else
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->price, 2) }} VNĐ</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $product->color->name ?? 'N/A' }}</td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                            <a href="{{ route('products.update', $product->id) }}">Sửa</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <script>
        document.getElementById('toggleFormButton').addEventListener('click', function() {
            const formContainer = document.getElementById('productForm');
            formContainer.classList.toggle('show'); // Thay đổi trạng thái hiển thị của form
        });
    </script>
</body>
</html>
