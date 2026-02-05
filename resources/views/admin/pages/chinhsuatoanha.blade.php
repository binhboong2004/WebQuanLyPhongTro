@extends('layouts.admin')

@section('title', 'Chỉnh sửa tòa nhà')

@section('content')
<main class="flex-1 p-8">
    <h2 class="text-xl font-bold mb-6">Chỉnh sửa tòa nhà: {{ $building->name }}</h2>

    <form action="{{ route('buildings.update', $building->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tên tòa nhà</label>
                <input type="text" name="name" value="{{ old('name', $building->name) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Địa chỉ</label>
                <input type="text" name="address" value="{{ old('address', $building->address) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Mô tả</label>
                <textarea name="description" class="search-input w-full border p-2 rounded-xl" rows="4">{{ old('description', $building->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nội quy</label>
                <textarea name="rules" class="search-input w-full border p-2 rounded-xl" rows="3">{{ old('rules', $building->rules) }}</textarea>
            </div>

            <div>
                <button type="submit" class="btn-primary">CẬP NHẬT</button>
                <a href="{{ route('buildings.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase hover:text-gray-600">Hủy</a>
            </div>
        </div>
    </form>
</main>
@endsection