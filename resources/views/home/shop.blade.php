@extends('home.index')
@section('content')
<section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
    </section>
    
    <section id="product1" class="section-p1">
        <div class="pro-container">
        @foreach ($products as $product)
        <div class="pro" onclick="window.location.href='{{ route('product.details', ['id' => $product->product_id]) }}';">
            <img src="{{ asset('images/products/' . $product->image1) }}" alt="{{ $product->product_name }}" />
                <div class="des">
                <span>{{ $product->category->category_name ?? 'Không có thể loại' }}</span>
                <h5>{{ $product->product_name }}</h5>
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
                <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
            </div>
            @endforeach          
        </div>
        <div class="custom-pagination">
        {{ $products->links() }}
    </div>
    </section>   
    @endsection