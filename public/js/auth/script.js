document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const loginBtn = document.querySelector('.login-btn');

    // 1. Logic Hiện/Ẩn mật khẩu mượt mà
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            // Chuyển đổi loại input
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            // Hiệu ứng xoay icon khi đổi
            this.style.transform = 'translateY(-50%) scale(0.8)';
            
            setTimeout(() => {
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
                this.style.transform = 'translateY(-50%) scale(1)';
            }, 100);
        });
    }

    // 2. Hiệu ứng Feedback khi bấm nút Login
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';
            // Laravel sẽ tự load trang nên chúng ta không cần gỡ spinner thủ công trừ khi dùng Ajax
        });
    }

    // 3. Tự động focus ô email khi tải trang
    const emailInput = document.querySelector('input[type="email"]');
    if (emailInput) {
        emailInput.focus();
    }
});