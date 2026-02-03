document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createAccountForm');

    form.addEventListener('submit', function(e) {
        const password = form.querySelector('input[name="password"]').value;
        const confirm = form.querySelector('input[name="password_confirmation"]').value;

        if (password !== confirm) {
            e.preventDefault();
            alert('Lỗi: Mật khẩu xác nhận không khớp!');
        }
    });
});