@extends('home.index') 

@section('content') 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    
<section id="page-header" class="about-header">
        <h2>#cart</h2>
        <p>Add your coupon code & SAVE upto 70%!</p>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                @if ($cartItems->count() > 0)
                    @foreach ($cartItems as $item)
                        <tr class="cart-item" data-id="{{ $item->CartItemId }}" data-updated-at="{{ $item->updated_at }}">
                            <td>
                                @if (file_exists(public_path('images/' . $item->product->image1. '.png')))
                                    <img src="{{ asset('images/' . $item->product->image1 . '.png') }}"
                                        alt="{{ $item->product->name }}" class="img-fluid" width="100">
                                @elseif(file_exists(public_path('images/' . $item->product->image1 . '.jpg')))
                                    <img src="{{ asset('images/' . $item->product->image1 . '.jpg') }}"
                                        alt="{{ $item->product->name }}" class="img-fluid" width="100">
                                @else
                                    <img src="{{ asset('images/default.png') }}" alt="{{ $item->product->name }}" class="img-fluid"
                                        width="100">
                                @endif
                        </td>
                            <td>{{ $item->product->name }}</td>
                            <td class="product-price">
                                {{ number_format($item->product->price, 0, ',', '.') }}₫
                            </td>
                            <td>
                                <button class="btn btn-outline-secondary quantity-btn decrease-btn">-</button>
                                <input type="text" class="form-control d-inline text-center quantity-input" style="width: 60px;"
                                    value="{{ $item->quantity }}" data-price="{{ $item->product->price }}" min="1">
                                <button class="btn btn-outline-secondary quantity-btn increase-btn">+</button>
                            </td>
                            <td class="product_item">{{ number_format($item->price, 0, ',', '.') }}₫
                            </td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                               
                                    <button class="btn btn-outline-danger delete-btn">🗑️</button>
                                    <div id="alert-box" style="display:none; position:fixed; top:20px; right:20px; z-index: 1050;"
                                        class="alert alert-success" role="alert"></div>
                                
                            </td>
                    </tr>
                @endforeach
            @else
                <tr>
                        <td colspan="7">Giỏ hàng của bạn hiện đang trống.</td>
                </tr>
            @endif

                <!-- <tr>
                    <td><a href="#"><i class="fas fa-times-circle" style="color:black"></i></a></td>
                    <td><img src="images/products/f2.jpg" alt=""></td>
                    <td>Cartoon Astronaut T-Shirt</td>
                    <td>$118.19</td>
                    <td><input type="number" value="1"></td>
                    <td>$118.19</td>
                </tr>
                <tr>
                    <td><a href="#"><i class="fas fa-times-circle" style="color:black"></i></a></td>
                    <td><img src="images/products/f3.jpg" alt=""></td>
                    <td>Cartoon Astronaut T-Shirt</td>
                    <td>$118.19</td>
                    <td><input type="number" value="1"></td>
                    <td>$118.19</td>
                </tr> -->
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div class="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div class="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td>$ 335</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$ 335</strong></td>
                </tr>
            </table>
            <button class="normal">Proceed to checkout</button>
        </div>
    </section>
@endsection