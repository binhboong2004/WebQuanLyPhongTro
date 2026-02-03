/**
 * Biến lưu trữ trạng thái Sidebar và Modal
 */
const menuToggle = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const modalOverlay = document.getElementById('modal-overlay');
const modalContent = document.getElementById('modal-content');

// Xử lý bật/tắt Sidebar trên Mobile
if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
}

// Đóng Modal
function closeModal() {
    modalOverlay.classList.add('hidden');
}

// Đóng modal khi click ra ngoài vùng nội dung
if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });
}

/**
 * Dữ liệu dịch vụ giả lập (Cấu hình FE)
 * Tách biệt dịch vụ đo lường (Measured) và dịch vụ cố định (Fixed)
 */
const roomServices = {
    // Dịch vụ cần nhập chỉ số
    'dien': { name: 'Điện', old: 1240, price: 3500, unit: 'kWh', isMeasured: true },
    'nuoc': { name: 'Nước', old: 45, price: 15000, unit: 'm³', isMeasured: true },
    
    // Dịch vụ cố định (Admin đã cấu hình sẵn)
    'others': [
        { name: 'Rác sinh hoạt', price: 50000, unit: 'Tháng' },
        { name: 'Thang máy', price: 30000, unit: 'Người' },
        { name: 'Phí dịch vụ chung', price: 100000, unit: 'Phòng' }
    ]
};

/**
 * Hàm mở Modal linh hoạt
 */
function openModal(type) {
    if (!modalOverlay || !modalContent) return;
    modalOverlay.classList.remove('hidden');

    if (type === 'qr-modal') {
        renderQR();
    } else if (type === 'decl-modal') {
        renderDeclarationForm();
    } else if (type === 'bill-modal') {
        renderBill();
    }
}

/**
 * Render Form khai báo chỉ số và tính tổng kèm dịch vụ khác
 */
function renderDeclarationForm() {
    // Tính tổng tiền các dịch vụ cố định trước
    const totalFixed = roomServices.others.reduce((sum, item) => sum + item.price, 0);
    
    // Tạo danh sách hiển thị dịch vụ cố định
    const fixedServicesHtml = roomServices.others.map(item => `
        <div class="flex justify-between text-[11px] text-slate-500 py-1 border-b border-teal-50 border-dotted">
            <span>${item.name}:</span>
            <span class="font-bold">${item.price.toLocaleString()}đ</span>
        </div>
    `).join('');

    modalContent.innerHTML = `
        <h3 class="text-2xl font-black text-slate-800 mb-6 italic">Khai báo & Tạm tính</h3>
        
        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
            <div class="p-4 bg-orange-50/50 rounded-2xl border border-orange-100">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-black text-orange-600 uppercase italic">Số Điện (kWh)</span>
                    <span class="text-[10px] bg-white px-2 py-1 rounded-lg border border-orange-100 italic text-slate-400">Số cũ: ${roomServices.dien.old}</span>
                </div>
                <input type="number" id="input-dien" oninput="calculateGrandTotal()" 
                    class="w-full p-3 bg-white border-2 border-orange-100 rounded-xl font-bold outline-none focus:border-orange-400" 
                    placeholder="Nhập số điện mới">
            </div>

            <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-black text-blue-600 uppercase italic">Số Nước (m³)</span>
                    <span class="text-[10px] bg-white px-2 py-1 rounded-lg border border-blue-100 italic text-slate-400">Số cũ: ${roomServices.nuoc.old}</span>
                </div>
                <input type="number" id="input-nuoc" oninput="calculateGrandTotal()" 
                    class="w-full p-3 bg-white border-2 border-blue-100 rounded-xl font-bold outline-none focus:border-blue-400" 
                    placeholder="Nhập số nước mới">
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Dịch vụ cố định (Tháng)</p>
                ${fixedServicesHtml}
            </div>

            <div class="border-2 border-dashed border-teal-200 p-4 rounded-2xl text-center text-teal-600 cursor-pointer">
                <i class="fa fa-camera mb-1"></i><br>
                <span class="text-[10px] font-bold uppercase">Tải ảnh đồng hồ</span>
                <input type="file" class="hidden">
            </div>
        </div>

        <div class="mt-6 p-4 bg-teal-600 rounded-2xl text-white shadow-lg shadow-teal-100">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-[10px] font-bold uppercase opacity-80 italic">Tổng tạm tính tháng này</p>
                    <h2 id="grand-total" class="text-3xl font-black">0đ</h2>
                </div>
                <i class="fa fa-calculator opacity-30 text-3xl"></i>
            </div>
        </div>

        <button onclick="submitData()" class="w-full mt-4 bg-slate-800 text-white py-4 rounded-2xl font-black active:scale-95 transition-all">GỬI BÁO CÁO</button>
    `;
    
    // Gọi tính toán lần đầu để cộng các phí cố định
    calculateGrandTotal();
}

/**
 * Render Hóa đơn demo tháng này
 */
function renderBill() {
    const currentDate = new Date();
    const month = currentDate.getMonth() + 1;
    const year = currentDate.getFullYear();
    const monthYear = `${month < 10 ? '0' + month : month}/${year}`;
    
    // Dữ liệu demo hóa đơn
    const billData = {
        room: "P.302 - Sky Tower",
        tenant: "Nguyễn Văn Nam",
        month: monthYear,
        items: [
            { name: "Tiền phòng", amount: 2500000, unit: "Tháng" },
            { name: "Điện", amount: 437500, unit: "125 kWh × 3.500đ" },
            { name: "Nước", amount: 75000, unit: "5 m³ × 15.000đ" },
            { name: "Rác sinh hoạt", amount: 50000, unit: "Tháng" },
            { name: "Thang máy", amount: 30000, unit: "Người" },
            { name: "Phí dịch vụ chung", amount: 100000, unit: "Phòng" }
        ]
    };
    
    const totalAmount = billData.items.reduce((sum, item) => sum + item.amount, 0);
    
    const itemsHtml = billData.items.map(item => `
        <div class="flex justify-between items-center py-3 border-b border-slate-100">
            <div class="flex-1">
                <p class="text-sm font-bold text-slate-700">${item.name}</p>
                <p class="text-[10px] text-slate-400 italic">${item.unit}</p>
            </div>
            <p class="text-sm font-black text-slate-800 ml-4">${item.amount.toLocaleString('vi-VN')}đ</p>
        </div>
    `).join('');

    modalContent.innerHTML = `
        <div class="max-h-[80vh] overflow-y-auto pr-2">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-black text-slate-800 mb-2 italic">HÓA ĐƠN THANH TOÁN</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Tháng ${billData.month}</p>
            </div>

            <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl p-6 mb-6 border border-teal-100">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">Phòng:</span>
                        <span class="text-sm font-black text-slate-800">${billData.room}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">Người thuê:</span>
                        <span class="text-sm font-black text-slate-800">${billData.tenant}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">Kỳ thanh toán:</span>
                        <span class="text-sm font-black text-teal-600">Tháng ${billData.month}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 mb-6">
                <h4 class="text-xs font-black text-slate-600 uppercase mb-4 tracking-wider">Chi tiết các khoản phí</h4>
                ${itemsHtml}
            </div>

            <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg shadow-teal-100">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <p class="text-[10px] font-bold uppercase opacity-90 italic mb-1">Tổng cộng</p>
                        <h2 class="text-4xl font-black">${totalAmount.toLocaleString('vi-VN')}đ</h2>
                    </div>
                    <i class="fa fa-file-invoice-dollar text-4xl opacity-30"></i>
                </div>
                <div class="pt-4 border-t border-teal-500/30 mt-4">
                    <p class="text-[9px] opacity-80 italic">Hạn thanh toán: Ngày 05/${month < 10 ? '0' + month : month}/${year}</p>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button onclick="closeModal()" class="flex-1 py-3 text-slate-400 font-bold text-xs uppercase tracking-widest border border-slate-200 rounded-xl hover:bg-slate-50 transition">Đóng</button>
                <button onclick="openModal('qr-modal')" class="flex-[2] py-3 bg-teal-600 text-white rounded-xl font-black shadow-lg shadow-teal-100 active:scale-95 transition-all">
                    <i class="fa fa-qrcode mr-2"></i>Thanh toán ngay
                </button>
            </div>
        </div>
    `;
}

/**
 * Logic tính toán tổng tiền thời gian thực
 */
function calculateGrandTotal() {
    const dienInput = document.getElementById('input-dien');
    const nuocInput = document.getElementById('input-nuoc');
    if (!dienInput || !nuocInput) return;
    
    const dienMoi = parseFloat(dienInput.value) || 0;
    const nuocMoi = parseFloat(nuocInput.value) || 0;
    
    // Tính tiền điện
    let tienDien = 0;
    if (dienMoi > roomServices.dien.old) {
        tienDien = (dienMoi - roomServices.dien.old) * roomServices.dien.price;
    }

    // Tính tiền nước
    let tienNuoc = 0;
    if (nuocMoi > roomServices.nuoc.old) {
        tienNuoc = (nuocMoi - roomServices.nuoc.old) * roomServices.nuoc.price;
    }

    // Tiền cố định
    const tienCoDinh = roomServices.others.reduce((sum, item) => sum + item.price, 0);

    // Tổng cộng
    const total = tienDien + tienNuoc + tienCoDinh;
    
    const display = document.getElementById('grand-total');
    if (display) {
        display.innerText = total.toLocaleString('vi-VN') + 'đ';
    }
}

/**
 * Giả lập Render QR Thanh toán
 */
function renderQR() {
    // 1. Lấy số tiền từ thẻ Hóa đơn Dashboard (h3 có nội dung 3.450.000đ)
    // Nếu không tìm thấy, sẽ mặc định lấy từ kết quả tạm tính trong modal
    const dashboardAmountText = document.querySelector('h3.text-5xl.font-black')?.innerText;
    const grandTotalText = dashboardAmountText || document.getElementById('grand-total')?.innerText || "0đ";
    
    // Chỉ lấy phần số để truyền vào API VietQR
    const amount = grandTotalText.replace(/\D/g, ""); 
    
    // 2. Thông tin cá nhân & Cú pháp nội dung
    const userRoom = "P302";
    const userNameSimple = "NAM"; 
    const currentMonth = new Date().getMonth() + 1;
    const monthString = currentMonth < 10 ? `T0${currentMonth}` : `T${currentMonth}`;

    // Thông tin tài khoản của bạn
    const bankId = "MB"; 
    const accountNo = "6802122004";
    const accountName = "VU DUY BINH";
    
    // Nội dung: P302_T01_NAM
    const description = `${userRoom}_${monthString}_${userNameSimple}`;

    // Link API VietQR động (Sử dụng mẫu compact2 để hiện đầy đủ thông tin)
    const qrUrl = `https://img.vietqr.io/image/${bankId}-${accountNo}-compact2.png?amount=${amount}&addInfo=${encodeURIComponent(description)}&accountName=${encodeURIComponent(accountName)}`;

    modalContent.innerHTML = `
        <h3 class="text-2xl font-black text-slate-800 mb-2">Thanh toán VietQR</h3>
        <p class="text-[10px] text-slate-400 mb-6 uppercase font-bold tracking-widest text-center italic">Quét để tự động điền ${grandTotalText}</p>
        
        <div class="text-center">
            <div class="relative inline-block p-4 bg-white rounded-[2.5rem] border-4 border-teal-50 shadow-xl mb-6">
                <img src="${qrUrl}" alt="VietQR MBBank" class="w-56 h-56 rounded-xl mx-auto shadow-sm">
                <div class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] px-3 py-1 rounded-full font-black shadow-lg">
                    MBBANK
                </div>
            </div>
        </div>

        <div class="bg-slate-50 p-5 rounded-3xl text-left border border-teal-50 space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-[9px] text-slate-400 font-black uppercase">Chủ tài khoản:</span>
                <span class="text-sm font-bold text-slate-700 uppercase">Vũ Duy Bình</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-[9px] text-slate-400 font-black uppercase">Số tiền cần đóng:</span>
                <span class="text-lg font-black text-teal-600">${grandTotalText}</span>
            </div>

            <div class="pt-2 border-t border-slate-200 border-dashed">
                <p class="text-[9px] text-teal-600 font-black uppercase mb-1 italic">Nội dung chuyển khoản:</p>
                <div class="bg-white p-3 rounded-xl border border-teal-100 flex justify-between items-center">
                    <span class="font-mono font-bold text-slate-800">${description}</span>
                    <button onclick="navigator.clipboard.writeText('${description}')" class="text-teal-500 active:scale-90 transition">
                        <i class="fa fa-copy"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button onclick="closeModal()" class="flex-1 py-4 text-slate-400 font-bold text-xs uppercase tracking-widest">Đóng</button>
            <button onclick="confirmSent()" class="flex-[2] py-4 bg-teal-600 text-white rounded-2xl font-black shadow-lg shadow-teal-100 active:scale-95 transition-all">XÁC NHẬN ĐÃ CHUYỂN</button>
        </div>
    `;
}

function confirmSent() {
    alert("Cảm ơn bạn! Hệ thống đang kiểm tra giao dịch, hóa đơn sẽ được cập nhật trong ít phút.");
    closeModal();
}

function submitData() {
    alert("✅ Đã gửi khai báo thành công! Vui lòng chờ Admin duyệt chỉ số để xuất hóa đơn chính thức.");
    closeModal();
}
