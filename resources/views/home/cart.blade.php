@extends('home.index')

@section('content')
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
            @if (count($cart) > 0)
                @foreach ($cart as $id => $item)
                    <tr id="row-{{ $id }}">
                        <td><a href="#"><i class="fas fa-times-circle" style="color:black"></i></a></td>
                        <td><img src="{{ asset('images/products/' . $item['image']) }}" alt=""></td>
                        <td>{{ $item['name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.updateQuantity', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="button" onclick="updateQuantity({{ $id }}, -1)">-</button>
                                <input type="number" name="quantity" id="quantity-{{ $id }}" value="{{ $item['quantity'] }}" min="1" readonly>
                                <button type="button" onclick="updateQuantity({{ $id }}, 1)">+</button>
                            </form>
                        </td>
                        <td id="subtotal-{{ $id }}">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">Your cart is empty.</td>
                </tr>
            @endif

                <tr>
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
                </tr>
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