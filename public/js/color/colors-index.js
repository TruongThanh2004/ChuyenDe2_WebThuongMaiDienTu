
document.addEventListener('DOMContentLoaded', function () {
    // Tự động ẩn thông báo sau 5 giây
    var notification = document.getElementById('notification');
    if (notification && notification.innerText.trim() !== '') {
        setTimeout(function () {
            notification.style.display = 'none';
        }, 5000);
    }

    // Ẩn thông báo khi người dùng click chuột
    document.addEventListener('click', function () {
        if (notification) {
            notification.style.display = 'none';
        }
    });
});
// check box chọn nhiều
function toggleAll(source) {
const checkboxes = document.querySelectorAll('.remove-item');
checkboxes.forEach(checkbox => {
    checkbox.checked = source.checked;
});
}

function confirmDeleteAll() {
const selectedItems = [];
document.querySelectorAll('.remove-item:checked').forEach(checkbox => {
    selectedItems.push(checkbox.getAttribute('data-id'));
});

if (selectedItems.length > 0) {
    document.getElementById('selected-items').value = selectedItems.join(',');
    if (confirm('Bạn có chắc chắn muốn xóa các màu đã chọn?')) {
        document.getElementById('delete-selected-form').submit();
    }
} else {
    alert('Vui lòng chọn ít nhất một màu để xóa.');
}
}
