<aside id="sidebar" class="sidebar-container w-72 bg-white h-full border-r border-teal-100 flex flex-col transition-all duration-300 -translate-x-full lg:translate-x-0 fixed lg:relative z-40">
    <div class="p-6 border-b border-teal-50">
        <div class="flex items-center gap-3">
            <div class="bg-teal-600 p-2 rounded-xl text-white">
                <i class="fa fa-home-user text-xl"></i>
            </div>
            <span class="text-xl font-bold text-teal-800 tracking-tight">SmartRent</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <div class="menu-group">
            <p class="menu-label">Quản lý thông tin</p>
            <div class="menu-item active"><i class="fa fa-home"></i><span>Trang chủ</span></div>
            <div class="menu-item"><i class="fa fa-user-circle"></i><span>Chỉnh sửa thông tin</span></div>
            <div class="menu-item"><i class="fa fa-key"></i><span>Đổi mật khẩu</span></div>
            <div class="menu-item"><i class="fa fa-users-gear"></i><span>Thành viên ở cùng</span></div>
        </div>

        <div class="menu-group">
            <p class="menu-label">Theo dõi hợp đồng</p>
            <div class="menu-item"><i class="fa fa-file-signature"></i><span>Xem hợp đồng</span></div>
            <div class="menu-item"><i class="fa fa-file-signature"></i><span>Khai báo tạm trú & tạm vắng</span></div>
            <div class="menu-item"><i class="fa fa-handshake"></i><span>Cam kết & Quy định</span></div>
        </div>

        <div class="menu-group">
            <p class="menu-label">Khai báo & Thanh toán</p>
            <div class="menu-item" onclick="openModal('decl-modal')"><i class="fa fa-bolt"></i><span>Khai báo điện/nước</span></div>
            <div class="menu-item" onclick="openModal('bill-modal')"><i class="fa fa-file-invoice-dollar"></i><span>Xem hóa đơn</span></div>
            <div class="menu-item"><i class="fa fa-receipt"></i><span>Lịch sử hóa đơn</span></div>
            <div class="menu-item" onclick="openModal('qr-modal')"><i class="fa fa-qrcode"></i><span>Thanh toán online</span></div>
        </div>

        <div class="menu-group border-t border-teal-50 pt-4">
            <div class="menu-item text-red-500 hover:bg-red-50"><i class="fa fa-warning"></i><span>Báo cáo sự cố</span></div>
        </div>
    </nav>

    <div class="p-4 bg-teal-50 m-4 rounded-2xl">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Van+Nam&background=0D9488&color=fff" class="w-10 h-10 rounded-full shadow-sm">
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-teal-900 truncate">Nguyễn Văn Nam</p>
                <p class="text-[10px] text-teal-600 uppercase font-bold tracking-widest">P.302 - Sky Tower</p>
            </div>
        </div>
    </div>
</aside>