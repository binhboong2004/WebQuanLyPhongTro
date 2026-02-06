@extends('layouts.user')
@section('title', 'Trang chủ')
@section('content')
<main class="flex-1 overflow-y-auto relative p-4 lg:p-10">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-slate-800">Bảng điều khiển</h2>
        <div class="flex gap-4">
            <button class="icon-btn"><i class="fa fa-bell"></i></button>

            <a href="{{ route('logout') }}"
                class="bg-teal-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-teal-100"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    @if($invoice)
                    <p class="text-teal-100 text-sm font-bold uppercase mb-2">Hóa đơn tháng {{ \Carbon\Carbon::parse($invoice->month_year ?? $invoice->created_at)->format('m/Y') }}</p>
                    <h3 class="text-5xl font-black mb-6">{{ number_format($invoice->total_amount, 0, ',', '.') }}đ</h3>
                    @elseif($reading)
                    <p class="text-teal-100 text-sm font-bold uppercase mb-2">Chỉ số cập nhật tháng {{ \Carbon\Carbon::parse($reading->reading_date)->format('m/Y') }}</p>
                    <h3 class="text-5xl font-black mb-6">—</h3>
                    @else
                    <p class="text-teal-100 text-sm font-bold uppercase mb-2">Hóa đơn</p>
                    <h3 class="text-5xl font-black mb-6">Chưa có dữ liệu</h3>
                    @endif

                    <button onclick="openModal('qr-modal')" class="bg-white text-teal-700 font-bold px-8 py-4 rounded-2xl shadow-lg active:scale-95 transition">THANH TOÁN NGAY</button>
                </div>
                <i class="fa fa-wallet absolute -bottom-10 -right-10 text-[15rem] opacity-10"></i>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="data-card">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 flex items-center justify-center rounded-xl text-xl"><i class="fa fa-bolt"></i></div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Chỉ số điện</p>
                            @php
                            $elec = null;
                            if(isset($reading) && $reading->electricity_index !== null && $reading->old_electricity_index !== null) {
                            $elec = $reading->electricity_index - $reading->old_electricity_index;
                            }
                            @endphp
                            <p class="text-xl font-black text-slate-700">{{ $elec !== null ? number_format($elec, 0, ',', '.') . ' kWh' : '—' }}</p>
                        </div>
                    </div>
                </div>
                <div class="data-card">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 flex items-center justify-center rounded-xl text-xl"><i class="fa fa-droplet"></i></div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Chỉ số nước</p>
                            @php
                            $water = null;
                            if(isset($reading) && $reading->water_index !== null && $reading->old_water_index !== null) {
                            $water = $reading->water_index - $reading->old_water_index;
                            }
                            @endphp
                            <p class="text-xl font-black text-slate-700">{{ $water !== null ? number_format($water, 0, ',', '.') . ' m³' : '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] p-6 border border-teal-50 shadow-sm">
                <h4 class="font-bold text-slate-700 mb-4 border-b border-teal-50 pb-2">Thành viên cùng phòng ({{ $members->count() }})</h4>
                <ul class="space-y-4">
                    @if($members->count())
                    @foreach($members as $member)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-full"></div>
                        <span class="text-sm font-semibold">{{ $member->name }}</span>
                    </li>
                    @endforeach
                    @else
                    <li class="text-sm text-slate-500">Chưa có thành viên</li>
                    @endif
                </ul>
                <button class="w-full mt-4 py-2 text-teal-600 font-bold text-xs border border-dashed border-teal-200 rounded-xl">+ Thêm thành viên</button>
            </div>
        </div>
    </div>
</main>
@endsection