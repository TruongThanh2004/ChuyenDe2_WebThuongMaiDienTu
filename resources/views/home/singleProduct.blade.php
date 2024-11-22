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
<style>
    /* Định dạng cho phần bình luận */
.comment-section {
    margin-top: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.comment-section h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.comment-section form {
    margin-bottom: 30px;
}

.comment-section form div {
    margin-bottom: 15px;
}

.comment-section form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.comment-section form input,
.comment-section form textarea {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
    box-sizing: border-box;
}

.comment-section form textarea {
    resize: vertical;
    height: 120px;
}

.comment-section form button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.comment-section form button:hover {
    background-color: #45a049;
}

/* Định dạng cho các bình luận đã gửi */
.comment-list {
    margin-top: 20px;
}

.comment-item {
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.comment-item strong {
    font-size: 16px;
    color: #333;
}

.comment-item p {
    font-size: 14px;
    color: #555;
    margin-top: 5px;
}

.comment-item small {
    display: block;
    margin-top: 10px;
    font-size: 12px;
    color: #888;
}
    
</style>

<div class="comment-section">
    <h3>Bình luận</h3>
    <form action="{{ route('singleProduct.comments.store', $product->product_id) }}" method="POST">
        @csrf
        <div>
            <label for="name">Tên:</label>
            <input type="text" name="name" value="{{ Auth::user()->username }}" id="name" readonly>
        </div>
        <div>
            <label for="comment">Nội dung:</label>
            <textarea name="comment" id="comment" rows="4" required></textarea>
        </div>
        <button type="submit">Gửi</button>
    </form>

    <h4>Các bình luận:</h4>
    <div class="comment-list">
        @if ($product->comments->count())
            @foreach ($product->comments as $comment)
                <div class="comment-item">
                    <strong>{{ $comment->name }}</strong>:
                    <p>{{ $comment->comment }}</p>
                    <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                </div>
            @endforeach
        @else
            <p>Chưa có bình luận nào.</p>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const quantityInput = document.getElementById('quantityInput');
    const maxQuantity = parseInt(quantityInput.getAttribute('max'), 10);

    quantityInput.addEventListener('input', () => {
        const value = parseInt(quantityInput.value, 10);

        if (isNaN(value) || value < 1 || value > maxQuantity) {
            swal({
                title: "Số lượng không hợp lệ!",
                text: `Số lượng phải phù hợp với số lượng đang có từ 1 đến ${maxQuantity}.`,
                icon: "error",
                button: "OK",
            }).then(() => {
                if (value < 1) {
                    quantityInput.value = 1;
                } else if (value > maxQuantity) {
                    quantityInput.value = maxQuantity;
                }
            });
        }
    });
});

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