@extends('home.index')
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<section id="page-header" class="about-header">
    <h2>Giỏ Hàng Của Bạn</h2>
    <p>Mua Sắm Thôi Nào</p>
</section>


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

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
                        <td class="product-price">{{ number_format($item->product->price * $item->quantity, 2, ',', '.') }} VNĐ
                        </td>
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
        <button type="button" class="btn btn-outline-danger delete-btn" onclick="confirmDeleteAll()">delete
            check</button>
    </form>
</section>

<section id="cart-add" class="section-p1">
    <div class="coupon">
        <!-- <h3>Apply Coupon</h3> -->
        <div>
            <!-- <input type="text" placeholder="Enter Your Coupon">
            <button class="normal">Apply</button> -->
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
            <button type="submit" class="normal">Mua Hàng</button>
        </form>
    </div>
</section>

<script src="{{ asset('js/cart/cart-list.js') }}"></script>
<script>
     // đặt hàng
     document.querySelector('form[action="{{ route('cart.Checkout') }}"]').addEventListener('submit', function (event) {
        event.preventDefault();
        const selectedItems = Array.from(document.querySelectorAll('.remove-item:checked')).map(item => item.dataset.id);

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'error',
                // title: 'Lỗi!',
                text: 'Vui lòng chọn ít nhất một sản phẩm để đặt hàng.',
            });
            return;
        }

        // Kiểm tra tồn tại sản phẩm qua AJAX
        fetch("{{ route('cart.checkItems') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ selected_items: selectedItems })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    Swal.fire({
                        icon: 'error',
                        text: data.message,
                    });
                } else {
                    // Tạo input ẩn và gửi form nếu tất cả sản phẩm tồn tại
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'selected_items';
                    hiddenInput.value = JSON.stringify(selectedItems);
                    this.appendChild(hiddenInput);
                    this.submit();
                }
            })
            .catch(error => console.error('Lỗi kiểm tra tồn tại sản phẩm:', error));
    });
    //  Cập nhật số lượng khi nhấn nút tăng
    document.querySelectorAll('.increase-btn').forEach(button => {
        button.addEventListener('click', function () {
            const cartItemRow = button.closest('.cart-item');
            const quantityInput = cartItemRow.querySelector('.quantity-input');
            const priceCell = cartItemRow.querySelector('.product-price');
            const price = parseFloat(quantityInput.dataset.price);
            let quantity = parseInt(quantityInput.value);

            quantity++;
            quantityInput.value = quantity;
            const totalPrice = price * quantity;
            priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 2 })} VNĐ`;
            updateCartTotal(totalPrice - (price * (quantity - 1))); // Cập nhật với sự thay đổi
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
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;
                const totalPrice = price * quantity;
                priceCell.textContent = `${totalPrice.toLocaleString('vi-VN', { minimumFractionDigits: 2 })} VNĐ`;
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
    console.error('Lỗi:', error);
    Swal.fire({
        icon: 'error',
        text: 'Có lỗi xảy ra. Vui lòng thử lại.',
    });
});
           
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection