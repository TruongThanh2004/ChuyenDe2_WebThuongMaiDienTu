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
                        <td class="product-price">{{ number_format($item->product->price*$item->quantity, 2, ',', '.') }} VNĐ</td>
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
    <form id="delete-selected-form" action="{{ route('cart.destroySelected') }}" method="POST">
        @csrf
        @method('DELETE')
        <td><input type="checkbox" id="remove-all" onclick="toggleAll(this)"></td>
        <input type="hidden" name="selected_items" id="selected-items">
        <button type="button" class="btn btn-outline-danger delete-btn" onclick="confirmDeleteAll()">Xóa các sản phẩm đã
            chọn</button>
    </form>
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
                <td>
                    <strong id="cart-total">
                        @if ($cartItems->isEmpty())
                            0
                        @else
                            {{ number_format($totalAmount, 2, ',', '.') }}
                        @endif
                        VNĐ
                    </strong>
                </td>
            </tr>
        </table>
        <form action="{{ route('cart.Checkout') }}" method="POST">
            @csrf
            <button type="submit" class="normal">Thanh Toán</button>
        </form>
    </div>
</section>



<script>

    // check box
    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('.remove-item');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = source.checked;
        });
    }
    // xóa  1 đơn hàng
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
    document.querySelectorAll('.remove-item').forEach(checkbox => {
        checkbox.addEventListener('change', updateCartTotal);
    });
    function showAlert(message) {
        const alertBox = document.getElementById('alert-box');
        alertBox.innerText = message;
        alertBox.style.display = 'block';

        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 3000);
    }






    function updateCartTotal() {
        const totalElement = document.getElementById('cart-total');
        let total = 0;
        const checkedItems = document.querySelectorAll('.remove-item:checked');

        // Kiểm tra có sản phẩm nào được chọn không
        if (checkedItems.length === 0) {
            totalElement.textContent = '0 VNĐ'; // Hiển thị 0 VNĐ nếu không có sản phẩm nào được chọn
        } else {
            // Tính tổng giá cho các sản phẩm được chọn
            checkedItems.forEach(checkbox => {
                const cartItemRow = checkbox.closest('.cart-item');
                const priceCell = cartItemRow.querySelector('.product-price');
                const quantityInput = cartItemRow.querySelector('.quantity-input');

                const price = parseFloat(priceCell.textContent.replace(/\./g, '').replace(' VNĐ', '').replace(',', '.'));
                const quantity = parseInt(quantityInput.value);

                total += price; // Tính tổng tiền cho từng sản phẩm
            });

            // Cập nhật phần tổng tiền với định dạng chính xác
            totalElement.textContent = `${total.toLocaleString('vi-VN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} VNĐ`;
        }
    }

    document.querySelectorAll('.increase-btn, .decrease-btn').forEach(button => {
        button.addEventListener('click', updateCartTotal);
    });

    document.querySelectorAll('.remove-item').forEach(checkbox => {
        checkbox.addEventListener('change', updateCartTotal);
    });



    //  Cập nhật số lượng khi nhấn nút tăng
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
            priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 2 })} VNĐ`;


            // Cập nhật tổng tiền của giỏ hàng
            updateCartTotal(totalPrice - (price * (quantity - 1))); // Cập nhật với sự thay đổi
            // Gửi yêu cầu cập nhật số lượng đến server
            updateCartItem(cartItemRow.dataset.id, quantity);
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
                priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 2 })} VNĐ`;

                // Cập nhật tổng tiền của giỏ hàng
                updateCartTotal(-price); // Cập nhật với sự thay đổi

                // Gửi yêu cầu cập nhật số lượng đến server
                updateCartItem(cartItemRow.dataset.id, quantity);
            }
        });
    });

    // Hàm gửi yêu cầu AJAX cập nhật số lượng
    function updateCartItem(itemId, quantity) {
        let updateCartUrl = "{{ route('cart.update') }}";
        fetch(updateCartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: itemId, quantity: quantity })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Số lượng sản phẩm đã được cập nhật.');
                } else {
                    showAlert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }




    // Cập nhật tổng tiền khi trang được tải lại
    document.addEventListener('DOMContentLoaded', () => {
        updateCartTotal();
    });



    function confirmDeleteAll() {
        const selectedItems = Array.from(document.querySelectorAll('.remove-item:checked'))
            .map(item => item.dataset.id);

        if (selectedItems.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm để xóa.');
            return;
        }

        document.getElementById('selected-items').value = JSON.stringify(selectedItems);

        if (confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn không?')) {
            document.getElementById('delete-selected-form').submit();
        }
    }
    //thanh toán
    document.querySelector('form[action="{{ route('cart.Checkout') }}"]').addEventListener('submit', function (event) {
        event.preventDefault();
        const selectedItems = Array.from(document.querySelectorAll('.remove-item:checked')).map(item => item.dataset.id);

        if (selectedItems.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
            return;
        }

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'selected_items';
        hiddenInput.value = JSON.stringify(selectedItems);
        this.appendChild(hiddenInput);

        this.submit();
    });



</script>


@endsection