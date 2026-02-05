// Admin finance actions: approve, reject, preview
(function () {
    function openPreview(url) {
        if (!url) return;
        window.open(url, '_blank');
    }

    function approveAction(id) {
        if (!confirm('Xác nhận phê duyệt?')) return;
        var f = document.getElementById('approve-form-' + id);
        if (f) f.submit();
    }

    function rejectAction(id) {
        var note = prompt('Lý do từ chối (bắt buộc):');
        if (note === null) return;
        note = note.trim();
        if (note === '') {
            alert('Vui lòng nhập lý do từ chối');
            return;
        }
        var f = document.getElementById('reject-form-' + id);
        if (f) {
            f.querySelector('input[name="admin_note"]').value = note;
            f.submit();
        }
    }

    // Expose to global for inline onclick handlers in blades
    window.openPreview = openPreview;
    window.approveAction = approveAction;
    window.rejectAction = rejectAction;
})();
