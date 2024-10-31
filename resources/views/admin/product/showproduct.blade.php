@extends('home.index')
@section('content')
<!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->
<style>
    .custom-select {
        position: relative;
        width: 300px;
        cursor: pointer;
    }

    .select-trigger {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        gap: 10px;
    }

    .select-trigger span {
        font-size: 16px;
        flex-grow: 1;
    }

    .color-preview {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: transparent;
        /* Màu mặc định */
        border: 1px solid #ccc;
    }

    .options {
        list-style: none;
        margin: 0;
        padding: 0;
        display: none;
        /* Ẩn mặc định */
        position: absolute;
        width: 100%;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
    }

    .options.show {
        display: block;
        /* Hiển thị khi cần */
    }

    .options li {
        display: flex;
        align-items: center;
        padding: 10px;
        gap: 10px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .options li:hover {
        background-color: #f1f1f1;
    }

    .options img {
        width: 100px;
        height: 50px;
        object-fit: contain;
        border-radius: 50%;
    }

    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-img {jhj
        max-width: 100%;
        height: 300%;
        object-fit: cover;
    }
</style>
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('script.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectTrigger = document.querySelector('.select-trigger');
        const options = document.querySelector('.options');
        const selectedColorInput = document.getElementById('selectedColor');
        const colorPreviewImg = document.querySelector('.preview-img'); // Lấy hình ảnh trong preview

        // Mở/Đóng combobox khi click vào trigger
        selectTrigger.addEventListener('click', () => {
            options.classList.toggle('show');
        });

        // Đóng combobox khi click ra ngoài
        document.addEventListener('click', (event) => {
            if (!selectTrigger.contains(event.target)) {
                options.classList.remove('show');
            }
        });

        // Cập nhật preview khi người dùng chọn màu
        options.querySelectorAll('li').forEach(option => {
            option.addEventListener('click', () => {
                const imageSrc = option.dataset.image; // Lấy đường dẫn hình ảnh
                const colorName = option.dataset.name; // Lấy tên màu

                console.log('Selected Image:', imageSrc); // Kiểm tra xem hình ảnh có đúng không

                // Cập nhật hình ảnh preview
                colorPreviewImg.src = imageSrc;
                colorPreviewImg.style.display = 'block'; // Hiển thị hình ảnh

                // Cập nhật tên màu trong trigger
                selectTrigger.querySelector('span').innerText = colorName;

                // Cập nhật giá trị vào input ẩn
                selectedColorInput.value = option.dataset.value;

                // Đóng danh sách sau khi chọn
                options.classList.remove('show');
            });
        });
    });



</script>
<section id="productdetails" class="section-p1">

    <div class="single-pro-image">
        <img src="{{ asset('images/products/' . $product->image1) }}" width="100%" id="MainImg"
            alt="{{ $product->product_name }}">
        <div class="small-image-group">
            <div class="small-img-col">
                <img src="{{ asset('images/products/' . $product->image1) }}" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="{{ asset('images/products/' . $product->image2) }}" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="{{ asset('images/products/' . $product->image3) }}" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="{{ asset('images/products/' . $product->image1) }}" width="100%" class="small-img" alt="">
            </div>
        </div>
        <a href="{{ route('admin.products') }}" class="btn-back">Quay lại danh sách sản phẩm</a>
    </div>
@endsection
