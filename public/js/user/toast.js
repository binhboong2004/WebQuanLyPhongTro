function showToast(message, type = 'success') {
    if (!message) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    const iconMap = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'warning': 'fa-exclamation-triangle',
        'info': 'fa-info-circle'
    };

    const icon = iconMap[type] || 'fa-bell';

    toast.innerHTML = `
        <i class="fa ${icon}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    console.log('✓ Toast displayed:', message, 'Type:', type);

    setTimeout(() => {
        toast.classList.add('slideOut');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function initToastSystem() {
    console.log('Toast system initializing...');

    const mainEl = document.querySelector('main[data-success]');

    if (!mainEl) {
        console.log('No main element with data-success found');
        return;
    }

    const success = mainEl.getAttribute('data-success');
    const message = mainEl.getAttribute('data-success-msg');

    console.log('Main element found');
    console.log('data-success:', success);
    console.log('data-success-msg:', message);

    if (success === '1' && message && message.trim() !== '') {
        console.log('Showing success toast:', message);
        showToast(message, 'success');
    } else if (!message || message.trim() === '') {
        console.log('Message is empty or not set');
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToastSystem);
} else {
    initToastSystem();
}

console.log('Toast.js loaded successfully');

function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

//doimatkhau page
const passwordInput = document.querySelector('input[name="password"]');

if (passwordInput) {
    passwordInput.addEventListener('input', function () {
        const pwd = this.value;
        const hasMinLength = pwd.length >= 8;
        const hasUpperCase = /[A-Z]/.test(pwd);
        const hasLowerCase = /[a-z]/.test(pwd);
        const hasNumber = /[0-9]/.test(pwd);

        updateRequirement('req-length', hasMinLength);
        updateRequirement('req-upper', hasUpperCase);
        updateRequirement('req-lower', hasLowerCase);
        updateRequirement('req-number', hasNumber);
    });
}

function updateRequirement(elementId, isMet) {
    const el = document.getElementById(elementId);
    if (el) {
        const icon = el.querySelector('i');
        if (isMet) {
            icon.className = 'fa fa-check-circle text-green-500';
            el.style.color = '#16a34a';
        } else {
            icon.className = 'fa fa-circle text-slate-300 text-[6px]';
            el.style.color = '#64748b';
        }
    }
}

//thanhvienocung page
// Đợi DOM load xong mới thực thi
document.addEventListener('DOMContentLoaded', function () {
    // 1. Kiểm tra trạng thái từ Laravel truyền sang
    if (window.LaravelData.isEditMode || window.LaravelData.hasErrors) {
        showAddForm();
        
        if (window.LaravelData.isEditMode) {
            const titleElem = document.getElementById('form-title');
            if (titleElem) titleElem.textContent = window.LaravelData.formTitleEdit;
        }
    }
});

// Hàm hiển thị Form
function showAddForm() {
    const container = document.getElementById('form-container');
    if (container) {
        container.classList.remove('hidden');
        container.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Hàm ẩn Form
function hideAddForm() {
    const container = document.getElementById('form-container');
    if (container) container.classList.add('hidden');
}

// Xử lý Preview ảnh (JS thuần)
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById(previewId);
            const container = document.getElementById(previewId + '-container');

            if (preview && container) {
                container.innerHTML = ''; // Xóa nội dung cũ
                
                // Cấu hình ảnh mới
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                container.appendChild(preview);

                // Thêm ghi chú
                const note = document.createElement('p');
                note.className = 'text-xs text-slate-500 mt-3';
                note.textContent = 'Nhấp để thay đổi';
                container.appendChild(note);
            }
        };
        reader.readAsDataURL(file);
    }
}
