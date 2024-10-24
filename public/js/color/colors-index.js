
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
