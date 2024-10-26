@extends('home.index')
@section('content')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('style.css') }}">
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('script.js') }}"></script>
<section id="productdetails" class="section-p1">
    
        <div class="single-pro-image">
        <img src="{{ asset('images/products/' . $product->image1) }}" width="100%" id="MainImg" alt="{{ $product->product_name }}">
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
            <select>
            <option>Select Color</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->color_id }}">{{ $color->name }}</option> <!-- Thay color_name bằng tên màu tương ứng -->
                @endforeach
            </select>
            <input type="number" value="1">
            <button class="normal">Add to Cart</button>
            <h4>Product Details</h4>
            <span>The Gildan Ultra Cotton T-shirt is made from a substantial 6.0 oz. per sq. yd. fabric
                constructed from 100% cotton, this classic fit preshrunk jersey knit provides unmatched comfort
                with each wear. Featuring a taped neck and shoulder, and a seamless double-needle collar, and available in a range
                of colors, it offers it all in the ultimate head-turning package.
            </span>
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
@endsection