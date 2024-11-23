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


