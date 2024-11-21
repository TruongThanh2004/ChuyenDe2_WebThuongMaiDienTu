@extends('home.index')
@section('content')
<head>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<section id="hero">
    <h4>Trade-in-offer</h4>
    <h2>Super value deals</h2>
    <h1>On all products</h1>
    <p>Save more with coupons & up to 70% off!</p>
    <button><a href="{{ route('shop') }}">Shop Now</a></button>
</section>

<section id="feature" class="section-p1">
    <div class="fe-box">
        <img src="images/features/f1.png" alt="">
        <h6>Free Shipping</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f2.png" alt="">
        <h6>Online Order</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f3.png" alt="">
        <h6>Save Money</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f4.png" alt="">
        <h6>Promotions</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f5.png" alt="">
        <h6>Happy Sell</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f6.png" alt="">
        <h6>F24/7 Support</h6>
    </div>
</section>



<section id="banner" class="section-m1">
    <h4>Repair Services</h4>
    <h2>Up to <span>70% Off</span> - All t-Shirts & Accessories</h2>
    <button class="normal">Explore More</button>
</section>

<section id="product1" class="section-p1">
    <h2>New Arrivals</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
        @foreach ($products as $product)
            <div class="pro">
                <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}"
                    onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';" />
                <div class="des">
                    <span>{{ $product->category->category_name ?? 'Không có thể loại' }}</span>
                    <h5>{{ $product->product_name }} </h5>
                    <div class="star">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $product->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <h4>{{ $product->price }}VND</h4>
                </div>
                <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    @if (auth()->check())
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif
                    <button type="submit" class="cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</section>

<section id="sm-banner" class="section-p1">
    <div class="banner-box">
        <h4>crazy deals</h4>
        <h2>buy 1 get 1 free</h2>
        <span>The best classic dress is on sale at cara</span>
        <button class="white">Learn more</button>
    </div>
    <div class="banner-box">
        <h4>spring/summer</h4>
        <h2>upcoming season</h2>
        <span>The best classic dress is on sale at cara</span>
        <button class="white">Collection</button>
    </div>
</section>

<section id="banner3">
    <div class="banner-box">
        <h2>SEASONAL SALE</h2>
        <h3>Winter Collection -50% OFF</h3>
    </div>
    <div class="banner-box">
        <h2>NEW FOOTWEAR COLLECTION</h2>
        <h3>Spring / Summer 2023</h3>
    </div>
    <div class="banner-box">
        <h2>T-SHIRTS</h2>
        <h3>New Trendy Prints</h3>
    </div>
</section>
@endsection