@extends('home.index')
@section('content')
<section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
    </section>
    
    <section id="product1" class="section-p1">
        <div class="pro-container">
        @foreach ($products as $product)
            <div class="pro">
                <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}"
                    onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';" />
                <div class="des">
                <span>{{ $product->category->category_name ?? 'Không có thể loại' }}</span>
                    <h5 onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';">
                        {{ $product->product_name }}</h5>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
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
        <div class="custom-pagination">
        {{ $products->links() }}
    </div>
    </section>   
    @endsection