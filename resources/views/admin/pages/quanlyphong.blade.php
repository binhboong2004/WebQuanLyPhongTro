@extends('layouts.admin')

@section('title', 'Quản lý phòng')

@section('content')
<main class="flex-1 flex flex-col min-h-screen overflow-y-auto bg-slate-50/50">
    <header class="h-16 min-h-[64px] bg-white shadow-sm flex items-center justify-between px-8 z-10 w-full">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Hệ thống / Quản lý phòng</h2>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-xs font-black text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" class="w-10 h-10 rounded-xl shadow-sm border-2 border-blue-50">
        </div>
    </header>

    <div class="p-8 overflow-y-auto custom-scrollbar bg-slate-50/50">
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-md flex items-center justify-between animate-fade-in">
            <div class="flex items-center">
                <div class="bg-green-500 p-2 rounded-lg mr-3">
                    <i class="fa fa-check text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-green-800 uppercase tracking-widest">Thành công</p>
                    <p class="text-[11px] text-green-600 font-bold">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 transition-colors">
                <i class="fa fa-times"></i>
            </button>
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-gray-700">Danh sách phòng</h3>
            <a href="{{ route('rooms.create') }}" class="btn-primary">Thêm phòng</a>
        </div>

        <div class="table-container shadow-sm border border-slate-50 overflow-hidden bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-50 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="p-6">Phòng</th>
                            <th class="p-6">Tòa</th>
                            <th class="p-6 text-center">Giá</th>
                            <th class="p-6 text-center">Trạng thái</th>
                            <th class="p-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @forelse($rooms as $room)
                        <tr>
                            <td class="p-6 font-bold text-slate-700">{{ $room->room_number }}</td>
                            <td class="p-6 text-sm text-slate-500">{{ optional($room->building)->name }}</td>
                            <td class="p-6 text-center">{{ number_format($room->price_base,0,',','.') }}đ</td>
                            <td class="p-6 text-center">
                                @php
                                    $statusMap = ['available' => 'Trống', 'occupied' => 'Đang thuê', 'maintenance' => 'Bảo trì'];
                                @endphp
                                {{ $statusMap[$room->status] ?? ucfirst($room->status) }}
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="action-btn"><i class="fa fa-pen"></i></a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa phòng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn text-red-500"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-400 font-bold uppercase text-xs">Không có phòng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $rooms->links() }}</div>
    </div>
</main>
@endsection