@extends('layouts.admin')

@section('title', 'Trang chủ')

@section('content')
<main class="flex-1 flex flex-col overflow-hidden">
    <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 z-10">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Bảng điều khiển quản trị</h2>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-xs font-black text-gray-800">Vũ Duy Bình</p>
                <p class="text-[10px] text-green-500 font-bold uppercase">Super Admin</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff"
                class="w-10 h-10 rounded-xl shadow-sm border-2 border-blue-50">
        </div>
    </header>

    <div class="p-8 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card border-b-4 border-blue-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Tỉ lệ lấp đầy</p>
                <p class="text-3xl font-black text-slate-800">92%</p>
            </div>
            <div class="stat-card border-b-4 border-orange-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Chờ duyệt số</p>
                <p class="text-3xl font-black text-orange-500">09</p>
            </div>
            <div class="stat-card border-b-4 border-green-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Doanh thu dự kiến</p>
                <p class="text-3xl font-black text-green-500">320M</p>
            </div>
            <div class="stat-card border-b-4 border-purple-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Phản hồi mới</p>
                <p class="text-3xl font-black text-purple-500">05</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b bg-gray-50/30 flex justify-between items-center">
                <h3 class="font-black text-gray-800 italic uppercase text-sm tracking-tighter">Hàng chờ phê
                    duyệt chỉ số tháng này</h3>
                <span class="text-[10px] bg-orange-100 text-orange-600 px-2 py-1 rounded-lg font-bold">Cần xử lý
                    gấp</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b text-gray-400 text-[10px] uppercase font-black">
                        <tr>
                            <th class="p-6">Phòng / Tòa</th>
                            <th class="p-6">Dịch vụ</th>
                            <th class="p-6">Chỉ số đồng hồ (Cũ -> Mới)</th>
                            <th class="p-6 text-center">Minh chứng</th>
                            <th class="p-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-blue-50/40 transition-all">
                            <td class="p-6 font-bold text-slate-700">P.202 - SkyView
                                <span class="block text-[10px] text-gray-400 font-normal mt-1">Khách: Vũ Duy
                                    Bình</span>
                            </td>
                            <td class="p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="w-12 bg-blue-100 text-blue-600 px-2 py-1 rounded text-[10px] font-black italic text-center">ĐIỆN</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="w-12 bg-teal-100 text-teal-600 px-2 py-1 rounded text-[10px] font-black italic text-center">NƯỚC</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-6 text-sm text-slate-500 font-mono space-y-3">
                                <div class="flex items-center">
                                    <span class="w-12 text-right">4520</span>
                                    <i class="fa fa-arrow-right mx-4 text-slate-300"></i>
                                    <span class="w-12 text-left">4635</span>
                                </div>

                                <div class="flex items-center">
                                    <span class="w-12 text-right">45</span>
                                    <i class="fa fa-arrow-right mx-4 text-slate-300"></i>
                                    <span class="w-12 text-left">50</span>
                                </div>
                            </td>

                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <div class="relative group cursor-pointer"
                                        onclick="openPreview('https://images.unsplash.com/photo-1558402529-d2638a7023e9?q=80&w=1000')">
                                        <img src="https://images.unsplash.com/photo-1558402529-d2638a7023e9?q=80&w=200"
                                            class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <i class="fa fa-eye text-white text-[10px]"></i>
                                        </div>
                                    </div>
                                    <div class="relative group cursor-pointer"
                                        onclick="openPreview('https://images.unsplash.com/photo-1558402529-d2638a7023e9?q=80&w=1000')">
                                        <img src="https://images.unsplash.com/photo-1558402529-d2638a7023e9?q=80&w=200"
                                            class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <i class="fa fa-eye text-white text-[10px]"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-6">
                                <div class="flex justify-center gap-2">
                                    <button onclick="approveAction('P.202')"
                                        class="bg-green-500 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-green-100 active:scale-95 transition">DUYỆT</button>
                                    <button onclick="rejectAction('P.202')"
                                        class="bg-white text-red-500 border border-red-100 px-4 py-2 rounded-xl text-xs font-black hover:bg-red-50 transition">TỪ
                                        CHỐI</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection