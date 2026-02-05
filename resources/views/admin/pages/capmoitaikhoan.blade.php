@extends('layouts.admin')

@section('title', 'Cấp mới tài khoản')

@section('content')
<main class="flex-1 flex flex-col min-h-screen overflow-y-auto bg-slate-50/50">
    <header class="h-16 min-h-[64px] bg-white shadow-sm flex items-center justify-between px-8 z-10 w-full">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Hệ thống / Cấp tài khoản</h2>
        <a href="{{ route('users.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-all">
            <i class="fa fa-arrow-left mr-1"></i> QUAY LẠI DANH SÁCH
        </a>
    </header>

    <div class="p-8 overflow-y-auto custom-scrollbar">
        <div class="max-w-4xl mx-auto">
            
            {{-- Hiển thị thông báo lỗi nếu Validation thất bại --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fa fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-red-800 font-black uppercase text-xs">Có lỗi xảy ra:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-50 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Thông tin tài khoản mới</h3>
                    <p class="text-xs text-slate-400 font-medium">Hệ thống sẽ gửi thông tin đăng nhập đến email được đăng ký.</p>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6" id="createAccountForm">
                    @csrf
                    
                    {{-- Họ và tên --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all" placeholder="Nguyễn Văn A" required>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all" placeholder="name@example.com" required>
                    </div>

                    {{-- Số điện thoại --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all" placeholder="0908xxxxxx">
                    </div>

                    {{-- Vai trò --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Vai trò hệ thống <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all appearance-none">
                            <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Người thuê (Tenant)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                        </select>
                    </div>

                    {{-- Mật khẩu --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Mật khẩu <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all" placeholder="••••••••" required>
                    </div>

                    {{-- Nhập lại mật khẩu --}}
                    <div class="form-group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Xác nhận mật khẩu <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:outline-none transition-all" placeholder="••••••••" required>
                    </div>

                    <div class="md:col-span-2 mt-6 flex gap-4">
                        <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                            <i class="fa fa-user-plus mr-2"></i> TẠO TÀI KHOẢN NGAY
                        </button>
                        <button type="reset" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                            LÀM MỚI FORM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection