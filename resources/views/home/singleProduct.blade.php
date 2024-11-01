@extends('home.index')
@section('content')
<!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="{{ asset('css/singgleproduct.css') }}">
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('script.js') }}"></script>

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
    </div>
    <div class="single-pro-details">
        <h6>{{ $product->category->category_name ?? 'Không có thể loại' }}</h6>
        <h4>{{ $product->product_name }}</h4>
        <h2>{{ $product->price }} VND</h2>

        <!-- <select>
            <option>Select Color</option>
            @foreach ($colors as $color)
                <option value="{{ $color->color_id }}">{{ $color->name }}</option>  Thay color_name bằng tên màu tương ứng 
            @endforeach
        </select> -->

        <div class="custom-select">
            <div class="select-trigger">
                <span>Select Color</span>
                <div class="color-preview">
                    <img src="" alt="Selected Color" class="preview-img" style="display: none;">
                </div>

                <i class="fas fa-chevron-down"></i> <!-- Icon mũi tên -->
            </div>
            <ul class="options">
                @foreach ($colors as $color)
                    <li data-value="{{ $color->color_id }}" data-image="{{ asset('images/colors/' . $color->images) }}"
                        data-name="{{ $color->name }}">
                        <img src="{{ asset('images/colors/' . $color->images) }}" alt="{{ $color->name }}">
                        <span>{{ $color->name }}</span>
                    </li>

                @endforeach
            </ul>
        </div>
        <input type="hidden" name="selected_color" id="selectedColor">




        <input type="hidden" name="selected_color" id="selectedColor">
        <input type="number" value="1">
        <button class="normal">Add to Cart</button>
        <h4>Product Details</h4>
        <span>{{ $product->description}}</span>
    </div>
</section>

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
        <div class="pro">
            <img src="images/products/n1.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n2.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n3.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n4.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
    </div>
</section>
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const selectTrigger = document.querySelector('.select-trigger');
    const options = document.querySelector('.options');
    const selectedColorInput = document.getElementById('selectedColor');
    const colorPreviewImg = document.querySelector('.preview-img');
    const mainImg = document.getElementById('MainImg'); // Hình ảnh chính
    const smallImgs = document.querySelectorAll('.small-img'); // Danh sách ảnh nhỏ

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
            const imageSrc = option.dataset.image;
            const colorName = option.dataset.name;

            colorPreviewImg.src = imageSrc;
            colorPreviewImg.style.display = 'block';
            selectTrigger.querySelector('span').innerText = colorName;
            selectedColorInput.value = option.dataset.value;
            options.classList.remove('show');
        });
    });

    // Cập nhật hình ảnh chính khi nhấp vào một trong các ảnh nhỏ
    smallImgs.forEach(smallImg => {
        smallImg.addEventListener('click', () => {
            mainImg.src = smallImg.src; // Cập nhật hình ảnh chính bằng src của ảnh nhỏ
        });
    });
});

</script>
@endsection