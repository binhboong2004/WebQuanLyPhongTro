@extends('layouts.admin')

@section('title', 'Gửi thông báo')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Gửi thông báo mới</h3>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-700 font-bold mb-2">Lỗi:</p>
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tiêu đề *</label>
                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tiêu đề thông báo" value="{{ old('title') }}" required>
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nội dung *</label>
                    <textarea name="content" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập nội dung thông báo" required>{{ old('content') }}</textarea>
                    @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Loại thông báo *</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>Thông thường</option>
                        <option value="alert" {{ old('type') === 'alert' ? 'selected' : '' }}>Cảnh báo</option>
                        <option value="update" {{ old('type') === 'update' ? 'selected' : '' }}>Cập nhật</option>
                    </select>
                    @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">
                        Gửi thông báo
                    </button>
                    <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-400">
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection