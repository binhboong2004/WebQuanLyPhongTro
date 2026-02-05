@extends('layouts.admin')

@section('title', 'Chỉnh sửa tài khoản')

@section('content')
<main class="flex-1 p-8">
    <h2 class="text-xl font-bold mb-6">Chỉnh sửa tài khoản: {{ $user->name }}</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Họ tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Vai trò</label>
                <select name="role" class="search-input w-full border p-2 rounded-xl">
                    <option value="tenant" {{ $user->role == 'tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <hr class="my-4">
                <label class="block text-xs font-bold text-red-400 uppercase mb-2">Đổi mật khẩu (Để trống nếu giữ nguyên)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="password" name="password" placeholder="Mật khẩu mới" class="search-input border p-2 rounded-xl">
                    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" class="search-input border p-2 rounded-xl">
                </div>
            </div>

            <div class="md:col-span-2 mt-6">
                <button type="submit" class="btn-primary w-full md:w-auto px-10">
                    CẬP NHẬT TÀI KHOẢN
                </button>
                <a href="{{ route('users.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase hover:text-gray-600">Hủy bỏ</a>
            </div>
        </div>
    </form>
</main>
@endsection