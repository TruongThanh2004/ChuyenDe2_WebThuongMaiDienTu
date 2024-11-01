@extends('home.index')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<section id="page-header" class="about-header">
    <h2>#cart</h2>
    <p>Add your coupon code & SAVE up to 70%!</p>
</section>

<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td></td>
                <td>Image</td>
                <td>Name Product</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Remove</td>
            </tr>
        </thead>
        <tbody>
            @if ($cartItems->count() > 0)
                @foreach ($cartItems as $item)
                    <tr class="cart-item" data-id="{{ $item->id }}">
                        <td><input type="checkbox" class="remove-item" data-id="{{ $item->order_items_id }}"></td>
                        <td><img src="{{ asset('images/products/' . $item->product->image1) }}" alt=""></td>
                        <td>{{ $item->product->product_name }}</td>
                        <td>
                            <button class="btn btn-outline-secondary quantity-btn decrease-btn">-</button>
                            <input type="text" class="form-control d-inline text-center quantity-input" style="width: 40px;"
                                value="{{ $item->quantity }}" data-price="{{ $item->product->price }}" min="1">
                            <button class="btn btn-outline-secondary quantity-btn increase-btn">+</button>
                        </td>
                        <td class="product-price">{{ number_format($item->product->price, 2, ',', '.') }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.destroy', $item->order_items_id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger delete-btn"
                                    onclick="confirmDelete(event)">🗑️</button>
                                <div id="alert-box" style="display:none; position:fixed; top:20px; right:20px; z-index: 1050;"
                                    class="alert alert-success" role="alert"></div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">Giỏ hàng của bạn hiện đang trống.</td>
                </tr>
            @endif
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
                <td><strong>Tổng tiền</strong></td>
                <td><strong id="cart-total">{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</strong></td>

            </tr>
        </table>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="normal">Thanh Toán</button>
        </form>
    </div>
</section>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target.closest('.delete-form');

        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
            const cartItemRow = form.closest('.cart-item');
            const priceCell = cartItemRow.querySelector('.product-price');
            const quantityInput = cartItemRow.querySelector('.quantity-input');
            const price = parseFloat(priceCell.textContent.replace(/\./g, '').replace(' VNĐ', ''));
            const quantity = parseInt(quantityInput.value);

            form.submit();
            updateCartTotal(-price * quantity); // Cập nhật tổng tiền sau khi xóa
            showAlert('Sản phẩm đã được xóa khỏi giỏ hàng.');
        }
    }

    function showAlert(message) {
        const alertBox = document.getElementById('alert-box');
        alertBox.innerText = message;
        alertBox.style.display = 'block';

        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 3000);
    }

    function updateCartTotal(priceChange = 0) {
        const totalElement = document.getElementById('cart-total');
        let total = parseFloat(totalElement.textContent.replace(/\./g, '').replace(' VNĐ', '')) + priceChange;

        totalElement.textContent = `${total.toLocaleString('vi-VN')} VNĐ`;
    }

 
    // Cập nhật số lượng khi nhấn nút tăng
    document.querySelectorAll('.increase-btn').forEach(button => {
        button.addEventListener('click', function () {
            const cartItemRow = button.closest('.cart-item');
            const quantityInput = cartItemRow.querySelector('.quantity-input');
            const priceCell = cartItemRow.querySelector('.product-price');
            const price = parseFloat(quantityInput.dataset.price);
            let quantity = parseInt(quantityInput.value);

            // Tăng số lượng
            quantity++;
            quantityInput.value = quantity;

            // Cập nhật giá của sản phẩm
            const totalPrice = price * quantity;
            priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 3 })} VNĐ`;

            // Cập nhật tổng tiền của giỏ hàng
            updateCartTotal(totalPrice - (price * (quantity - 1))); // Cập nhật với sự thay đổi
        });
    });

    // Cập nhật số lượng khi nhấn nút giảm
    document.querySelectorAll('.decrease-btn').forEach(button => {
        button.addEventListener('click', function () {
            const cartItemRow = button.closest('.cart-item');
            const quantityInput = cartItemRow.querySelector('.quantity-input');
            const priceCell = cartItemRow.querySelector('.product-price');
            const price = parseFloat(quantityInput.dataset.price);
            let quantity = parseInt(quantityInput.value);

            // Giảm số lượng
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;

                // Cập nhật giá của sản phẩm
                const totalPrice = price * quantity;
                priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 3 })} VNĐ`;

                // Cập nhật tổng tiền của giỏ hàng
                updateCartTotal(-price); // Cập nhật với sự thay đổi
            }
        });
    });


    // Cập nhật tổng tiền khi trang được tải lại
    document.addEventListener('DOMContentLoaded', () => {
        updateCartTotal();
    });

</script>

@endsection