@extends('layouts.admin')

@section('title', 'Trang chủ')

@section('content')
<main class="flex-1 flex flex-col min-h-screen overflow-y-auto bg-slate-50/50">
    <header class="h-16 min-h-[64px] bg-white shadow-sm flex items-center justify-between px-8 z-10 w-full">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Bảng điều khiển quản trị</h2>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-xs font-black text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-[10px] text-green-500 font-bold uppercase tracking-widest">{{ auth()->user()->role ?? 'Manager' }}</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" class="w-10 h-10 rounded-xl shadow-sm border-2 border-blue-50">
        </div>
    </header>

    <div class="p-8 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card border-b-4 border-blue-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Tỉ lệ lấp đầy</p>
                <p class="text-3xl font-black text-slate-800">{{ $occupancyRate }}%</p>
                <p class="text-xs text-gray-400 mt-1">{{ $occupiedRooms }} / {{ $totalRooms }} phòng</p>
            </div>
            <div class="stat-card border-b-4 border-orange-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Chờ duyệt chỉ số</p>
                <p class="text-3xl font-black text-orange-500">{{ $pendingReadings->count() }}</p>
                <p class="text-xs text-gray-400 mt-1">Chờ xử lý</p>
            </div>
            <div class="stat-card border-b-4 border-green-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Tổng doanh thu</p>
                <p class="text-3xl font-black text-green-500">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                <p class="text-xs text-gray-400 mt-1">Số hoá đơn: {{ $totalInvoices }}</p>
            </div>
            <div class="stat-card border-b-4 border-purple-500">
                <p class="text-gray-400 text-[10px] font-black uppercase mb-1">Phản hồi mới</p>
                <p class="text-3xl font-black text-purple-500">{{ $pendingIssues }}</p>
                <p class="text-xs text-gray-400 mt-1">Vấn đề cần xử lý</p>
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
                        @forelse($pendingReadings as $reading)
                        <tr class="hover:bg-blue-50/40 transition-all">
                            <td class="p-6 font-bold text-slate-700">
                                {{ optional($reading->room)->room_number ?? '—' }}
                                <span class="block text-[10px] text-gray-400 font-normal mt-1">Tòa: {{ optional(optional($reading->room)->building)->name ?? '—' }}</span>
                                <span class="block text-[10px] text-gray-400 font-normal mt-1">Người tạo: {{ optional($reading->creator)->name ?? 'Hệ thống' }}</span>
                            </td>

                            <td class="p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-4">
                                        <span class="w-12 bg-blue-100 text-blue-600 px-2 py-1 rounded text-[10px] font-black italic text-center">ĐIỆN</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="w-12 bg-teal-100 text-teal-600 px-2 py-1 rounded text-[10px] font-black italic text-center">NƯỚC</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-6 text-sm text-slate-500 font-mono space-y-3">
                                <div class="flex items-center">
                                    <span class="w-12 text-right">{{ $reading->old_electricity_index ?? '—' }}</span>
                                    <i class="fa fa-arrow-right mx-4 text-slate-300"></i>
                                    <span class="w-12 text-left">{{ $reading->electricity_index ?? '—' }}</span>
                                </div>

                                <div class="flex items-center">
                                    <span class="w-12 text-right">{{ $reading->old_water_index ?? '—' }}</span>
                                    <i class="fa fa-arrow-right mx-4 text-slate-300"></i>
                                    <span class="w-12 text-left">{{ $reading->water_index ?? '—' }}</span>
                                </div>
                            </td>

                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($reading->image_proof_elec)
                                    <div class="relative group cursor-pointer" onclick="openPreview('{{ asset($reading->image_proof_elec) }}')">
                                        <img src="{{ asset($reading->image_proof_elec) }}" class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <i class="fa fa-eye text-white text-[10px]"></i>
                                        </div>
                                    </div>
                                    @endif

                                    @if($reading->image_proof_water)
                                    <div class="relative group cursor-pointer" onclick="openPreview('{{ asset($reading->image_proof_water) }}')">
                                        <img src="{{ asset($reading->image_proof_water) }}" class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <i class="fa fa-eye text-white text-[10px]"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <td class="p-6">
                                <div class="flex justify-center gap-2">
                                    <form id="approve-form-{{ $reading->id }}" action="{{ route('finance.readings.approve', $reading->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="admin_note" value="">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-green-100 active:scale-95 transition" onclick="return confirm('Xác nhận phê duyệt?')">DUYỆT</button>
                                    </form>
                                    <form id="reject-form-{{ $reading->id }}" action="{{ route('finance.readings.reject', $reading->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="admin_note" value="">
                                    </form>
                                    <button type="button" onclick="rejectAction('{{ $reading->id }}')" class="bg-white text-red-500 border border-red-100 px-4 py-2 rounded-xl text-xs font-black hover:bg-red-50 transition">TỪ CHỐI</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">Không có chỉ số chờ duyệt.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/admin/finance-actions.js') }}"></script>
@endsection