@extends('layouts.admin')

@section('title', 'Danh sách tài khoản')

@section('content')
<main class="flex-1 flex flex-col min-h-screen overflow-y-auto bg-slate-50/50">
    <header class="h-16 min-h-[64px] bg-white shadow-sm flex items-center justify-between px-8 z-10 w-full">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Hệ thống / Quản lý tài khoản</h2>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-xs font-black text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-[10px] text-green-500 font-bold uppercase tracking-widest">{{ auth()->user()->role ?? 'Manager' }}</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" class="w-10 h-10 rounded-xl shadow-sm border-2 border-blue-50">
        </div>
    </header>

    <div class="p-8 overflow-y-auto custom-scrollbar bg-slate-50/50">
        {{-- Thông báo thành công --}}
        @if(session('success'))
        <div id="success-alert" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-md flex items-center justify-between animate-fade-in">
            <div class="flex items-center">
                <div class="bg-green-500 p-2 rounded-lg mr-3">
                    <i class="fa fa-check text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-green-800 uppercase tracking-widest">Thành công</p>
                    <p class="text-[11px] text-green-600 font-bold">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('success-alert').remove()" class="text-green-400 hover:text-green-600 transition-colors">
                <i class="fa fa-times"></i>
            </button>
        </div>
        @endif

        {{-- Thông báo lỗi (ví dụ: tự xóa chính mình) --}}
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-md flex items-center">
            <div class="bg-red-500 p-2 rounded-lg mr-3">
                <i class="fa fa-exclamation-triangle text-white text-xs"></i>
            </div>
            <p class="text-[11px] text-red-600 font-bold">{{ session('error') }}</p>
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
            <div class="relative w-full md:w-96 group">
                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                <input type="text" id="userSearch" placeholder="Tìm kiếm nhanh..." class="search-input">
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('users.create') }}" class="btn-primary flex items-center">
                    <i class="fa fa-user-plus mr-2"></i> CẤP TÀI KHOẢN
                </a>
            </div>
        </div>

        <div class="table-container shadow-sm border border-slate-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-50 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="p-6">Người dùng</th>
                            <th class="p-6">Liên hệ</th>
                            <th class="p-6 text-center">Vai trò</th>
                            <th class="p-6 text-center">Ngày tham gia</th>
                            <th class="p-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @forelse($users as $user)
                        <tr class="user-row transition-all group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}"
                                        class="user-avatar shadow-sm object-cover">
                                    <div>
                                        <p class="text-sm font-black text-slate-700">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">ID: #USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="text-xs text-slate-600 font-bold">{{ $user->email }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $user->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="badge {{ $user->role == 'admin' ? 'badge-blue' : 'bg-slate-100 text-slate-500' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="p-6 text-center">
                                <span class="text-[11px] font-bold text-slate-500">{{ $user->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Nút Sửa: Chuyển hướng sang trang edit --}}
                                    <a href="{{ route('users.edit', $user->id) }}" class="action-btn hover:text-blue-600 hover:bg-blue-50" title="Chỉnh sửa">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    {{-- Nút Xóa: Gọi hàm JS --}}
                                    <button onclick="deleteAccount('{{ $user->id }}', '{{ $user->name }}')" class="action-btn hover:text-red-500 hover:bg-red-50" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    {{-- Form ẩn dùng để gửi request DELETE --}}
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-400 font-bold uppercase text-xs">
                                Chưa có tài khoản nào trong hệ thống.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</main>
@endsection