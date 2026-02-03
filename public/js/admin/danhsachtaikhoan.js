/**
 * Quản lý tài khoản - SmartRent
 */
document.addEventListener('DOMContentLoaded', function() {
    // Search Filter Logic
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
});

// Hàm xác nhận xóa
function deleteAccount(userId) {
    // Bạn có thể dùng SweetAlert2 ở đây cho đẹp hơn alert mặc định
    if (confirm(`Hệ thống: Bạn có chắc chắn muốn xóa tài khoản #${userId}?`)) {
        console.log(`Đang thực hiện xóa ID: ${userId}`);
        // Gửi AJAX delete request ở đây...
    }
}