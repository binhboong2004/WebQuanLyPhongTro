@extends('layouts.user')
@section('title', 'Chỉnh sửa thông tin')
@section('content')
<main class="flex-1 overflow-y-auto relative p-4 lg:p-10" data-success="{{ session('success') ? '1' : '0' }}" data-success-msg="{!! htmlspecialchars(session('success') ?? '', ENT_QUOTES, 'UTF-8') !!}">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-slate-800">Chỉnh sửa thông tin cá nhân</h2>
        <div class="flex gap-4">
            <a href="{{ route('user.index') }}"
                class="bg-slate-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-slate-100 hover:bg-slate-700 transition">
                Quay lại
            </a>
        </div>
    </header>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4 flex gap-3 items-start">
        <i class="fa fa-exclamation-circle text-red-500 mt-1"></i>
        <div>
            <p class="font-bold text-red-700 mb-2">Có lỗi xảy ra:</p>
            <ul class="text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4 flex gap-3 items-start">
        <i class="fa fa-check-circle text-green-500 mt-1"></i>
        <div>
            <p class="font-bold text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm sticky top-10">
                <div class="text-center">
                    <div class="relative inline-block mb-6">
                        <img id="avatarPreview"
                            src="{{ $user->avatar ? (filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset($user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D9488&color=fff&size=256' }}"
                            alt="Avatar"
                            class="w-40 h-40 rounded-lg object-cover border-4 border-teal-50 shadow-md">
                        <label for="avatarInput"
                            class="absolute bottom-1 right-1
                                bg-teal-600 text-white
                                w-10 h-10 flex items-center justify-center
                                rounded-full cursor-pointer
                                shadow-md hover:shadow-xl
                                hover:bg-teal-700 hover:scale-110
                                active:scale-95
                                transition">
                            <i class="fa fa-camera"></i>
                        </label>
                    </div>
                    
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                    <p class="text-xs text-slate-500 font-medium mb-5">JPEG, PNG, GIF • Max 2MB</p>
                    <div class="space-y-2">
                        <h3 class="font-bold text-lg text-slate-900">{{ $user->name }}</h3>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <span class="inline-block px-4 py-2 bg-teal-50 text-teal-700 rounded-lg text-xs font-bold uppercase tracking-wide">
                            <i class="fa fa-{{ $user->role === 'admin' ? 'shield-alt' : 'home' }} mr-2"></i>{{ $user->role === 'admin' ? 'Quản trị viên' : 'Người thuê' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Card -->
            <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm">
                <!-- Họ tên -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                        <i class="fa fa-user text-teal-600 mr-2"></i>Họ và tên
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        placeholder="Nhập họ và tên"
                        class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                    @error('name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-slate-200 my-6"></div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                        <i class="fa fa-envelope text-teal-600 mr-2"></i>Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        placeholder="Nhập địa chỉ email"
                        class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                    @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-2">Email được sử dụng để đăng nhập vào hệ thống</p>
                </div>

                <div class="border-t border-slate-200 my-6"></div>

                <!-- Số điện thoại -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                        <i class="fa fa-phone text-teal-600 mr-2"></i>Số điện thoại
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="Nhập số điện thoại"
                        class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Thông tin thêm -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold uppercase mb-2">ID Người dùng</p>
                    <p class="text-lg font-black text-slate-700">#{{ $user->id }}</p>
                </div>
                <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold uppercase mb-2">Tham gia từ</p>
                    <p class="text-lg font-black text-slate-700">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold px-8 py-4 rounded-lg shadow-md shadow-teal-200 hover:shadow-lg hover:from-teal-600 hover:to-teal-700 active:scale-95 transition">
                    <i class="fa fa-save mr-2"></i>Lưu thay đổi
                </button>
                <a href="{{ route('user.index') }}"
                    class="flex-1 bg-slate-100 text-slate-700 font-bold px-8 py-4 rounded-lg shadow-sm hover:bg-slate-200 active:scale-95 transition text-center">
                    <i class="fa fa-times mr-2"></i>Hủy
                </a>
            </div>
        </div>
    </form>
</main>
@endsection