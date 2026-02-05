@extends('layouts.admin')

@section('title', 'Thêm tòa nhà')

@section('content')
<main class="flex-1 p-8">
    <h2 class="text-xl font-bold mb-6">Thêm tòa nhà mới</h2>

    <form action="{{ route('buildings.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tên tòa nhà</label>
                <input type="text" name="name" value="{{ old('name') }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Địa chỉ</label>
                <input type="text" name="address" value="{{ old('address') }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Mô tả</label>
                <textarea name="description" class="search-input w-full border p-2 rounded-xl" rows="4">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nội quy</label>
                <textarea name="rules" class="search-input w-full border p-2 rounded-xl" rows="3">{{ old('rules') }}</textarea>
            </div>

            <div>
                <button type="submit" class="btn-primary">TẠO TÒA NHÀ</button>
                <a href="{{ route('buildings.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase hover:text-gray-600">Hủy</a>
            </div>
        </div>
    </form>
</main>
@endsection