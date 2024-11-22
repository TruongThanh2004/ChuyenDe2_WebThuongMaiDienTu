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
        <h2>Số lượng: {{ $product->quantity }}</h2>
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
        <input type="number" id="quantityInput" value="1" max="{{ $product->quantity }}" min="1">

        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    @if (auth()->check())
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif
                    <button class="normal">Add to Cart</button>
                </form>

        <!-- <button class="normal">Add to Cart</button> -->
        <h4>Product Details</h4>
        <span>{{ $product->description}}</span>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const selectTrigger = document.querySelector('.select-trigger');
    const options = document.querySelector('.options');
    const selectedColorInput = document.getElementById('selectedColor');
    const colorPreviewImg = document.querySelector('.preview-img');
    const mainImg = document.getElementById('MainImg'); 
    const smallImgs = document.querySelectorAll('.small-img'); 

    selectTrigger.addEventListener('click', (event) => {
        event.stopPropagation();
        options.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!selectTrigger.contains(event.target)) {
            options.classList.remove('show');
        }
    });

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

    let isAnimating = false;

    smallImgs.forEach(smallImg => {
        smallImg.addEventListener('click', () => {
            if (isAnimating) return;
            isAnimating = true;

            const targetSrc = smallImg.src;
            const currentSrc = mainImg.src;
            const direction = smallImg.offsetLeft < mainImg.offsetLeft ? 'left' : 'right';

            mainImg.style.transition = 'transform 0.5s ease-in-out';
            mainImg.style.transform = `translateX(${direction === 'left' ? '100%' : '-100%'})`;

            mainImg.addEventListener('transitionend', () => {
                mainImg.src = targetSrc;
                mainImg.style.transition = 'none';
                mainImg.style.transform = `translateX(${direction === 'left' ? '-100%' : '100%'})`;

                setTimeout(() => {
                    mainImg.style.transition = 'transform 0.5s ease-in-out';
                    mainImg.style.transform = 'translateX(0)';
                    isAnimating = false;
                }, 10);
            }, { once: true });
        });
    });
});

</script>
@endsection