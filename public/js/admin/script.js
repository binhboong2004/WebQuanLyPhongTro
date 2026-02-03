/**
 * SmartRent Admin - Logic điều khiển giao diện
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Xử lý đóng/mở Dropdown Menu ở Sidebar (Giữ nguyên)
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const dropdownItem = this.parentElement;
            const subMenu = dropdownItem.querySelector('.sub-menu');
            const icon = this.querySelector('.fa-chevron-down');

            const isHidden = subMenu.classList.toggle('hidden');

            if (!isHidden) {
                icon.style.transform = 'rotate(180deg)';
                this.classList.add('text-blue-400');
            } else {
                icon.style.transform = 'rotate(0deg)';
                this.classList.remove('text-blue-400');
            }
        });
    });

    // 2. Xử lý Active Menu Item (Giữ nguyên)
    const allLinks = document.querySelectorAll('.nav-item, .sub-menu a');
    allLinks.forEach(link => {
        link.addEventListener('click', function() {
            allLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

/**
 * Hàm phóng to ảnh
 */
function openPreview(imgSrc) {
    const modal = document.getElementById('preview-modal');
    const modalImg = document.getElementById('modal-img');
    if (!modal || !modalImg) return;
    modalImg.src = imgSrc;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Chặn cuộn trang
}

/**
 * Hàm đóng modal
 */
function closePreview() {
    const modal = document.getElementById('preview-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; // Cho phép cuộn lại
}

// Lắng nghe phím ESC để đóng ảnh
document.addEventListener('keydown', (e) => {
    if (e.key === "Escape") closePreview();
});

/**
 * Các hàm xử lý hành động (Giữ nguyên)
 */
function approveAction(roomId) {
    if(confirm(`Bạn có chắc chắn muốn phê duyệt chỉ số cho ${roomId}?`)) {
        alert(`✅ Đã phê duyệt và tự động tạo hóa đơn cho ${roomId}`);
    }
}

function rejectAction(roomId) {
    const reason = prompt(`Lý do từ chối cho ${roomId}:`);
    if (reason) {
        alert(`❌ Đã gửi yêu cầu khai báo lại cho người thuê với lý do: ${reason}`);
    }
}
