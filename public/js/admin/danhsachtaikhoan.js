/**
 * Quản lý tài khoản - SmartRent
 */
document.addEventListener('DOMContentLoaded', function() {
    // 1. Logic Tìm kiếm nhanh
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('.user-row');

            tableRows.forEach(row => {
                const content = row.textContent.toLowerCase();
                if (content.includes(searchTerm)) {
                    row.style.display = "";
                    row.classList.add('animate-fade-in');
                } else {
                    row.style.display = "none";
                }
            });
        });
    }

    // 2. Tự động ẩn thông báo thành công sau 4 giây
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(function() {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    }
});

/**
 * Hàm xác nhận xóa tài khoản
 * @param {number} userId - ID của người dùng
 * @param {string} userName - Tên của người dùng để hiển thị thông báo
 */
function deleteAccount(userId, userName) {
    // Hiển thị hộp thoại xác nhận của trình duyệt
    const confirmMessage = `Hệ thống SmartRent:\n\nBạn có chắc chắn muốn xóa tài khoản của "${userName}" (ID: #${userId}) không?\n\nHành động này không thể hoàn tác!`;
    
    if (confirm(confirmMessage)) {
        // Tìm form ẩn tương ứng theo ID đã đặt ở Blade
        const form = document.getElementById(`delete-form-${userId}`);
        if (form) {
            form.submit(); // Gửi request DELETE lên Controller
        } else {
            console.error("Không tìm thấy form xóa cho ID: " + userId);
        }
    }
}